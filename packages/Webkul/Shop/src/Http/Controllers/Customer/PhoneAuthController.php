<?php

namespace Webkul\Shop\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Webkul\Customer\Models\Customer;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Customer\Facades\Captcha;

class PhoneAuthController extends Controller
{
    /**
     * Send OTP to phone number
     */
    public function sendPhoneOtp(Request $request)
    {
        Log::info('SendPhoneOtp called', ['request' => $request->all()]);

        try {
            $request->validate([
                'phone' => [
                    'required',
                    'regex:/^(\+966|\+965|\+973|\+974|\+971|\+968)[0-9]{8,9}$/',
                ],
            ]);

            $phone = $this->formatPhoneNumber($request->phone);

            // Rate limiting: max 3 attempts per phone per hour
            $cacheKey = 'otp_attempts_' . md5($phone);
            $attempts = Cache::get($cacheKey, 0);

            if ($attempts >= 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'تم تجاوز الحد الأقصى للمحاولات. يرجى المحاولة لاحقاً.'
                ], 429);
            }

            // Find existing customer or create new one
            $customer = Customer::where('phone', $phone)->first();

            if (!$customer) {
                $customer = $this->createPhoneCustomer($phone);
            }

            // Generate and save OTP
            $otp = $customer->generatePhoneOtp();

            // Send OTP via WhatsApp
            if ($this->sendWhatsAppOtp($customer, $otp)) {
                // Increment attempts counter
                Cache::put($cacheKey, $attempts + 1, 3600); // 1 hour

                return response()->json([
                    'success' => true,
                    'message' => 'تم إرسال رمز التحقق عبر WhatsApp',
                    'is_new_customer' => $customer->wasRecentlyCreated
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'فشل في إرسال رمز التحقق'
            ], 500);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات غير صحيحة',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('SendPhoneOtp Exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify OTP and login customer
     */
    public function verifyPhoneOtp(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required|string',
                'otp' => 'required|digits:6',
            ]);

            $phone = $this->formatPhoneNumber($request->phone);
            $otp = $request->otp;

            // Rate limiting for verification attempts
            $cacheKey = 'otp_verify_attempts_' . md5($phone);
            $verifyAttempts = Cache::get($cacheKey, 0);

            if ($verifyAttempts >= 5) {
                return response()->json([
                    'success' => false,
                    'message' => 'تم تجاوز عدد محاولات التحقق. يرجى طلب رمز جديد.'
                ], 429);
            }

            // Find customer
            $customer = Customer::where('phone', $phone)->first();

            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'رقم الهاتف غير مسجل'
                ], 404);
            }

            // Verify OTP
            if ($customer->verifyPhoneOtp($otp)) {
                // Clear rate limiting caches
                Cache::forget('otp_attempts_' . md5($phone));
                Cache::forget($cacheKey);

                // Login the customer
                auth()->guard('customer')->login($customer, true);

                // Send welcome message
                $this->sendWelcomeMessage($customer);

                return response()->json([
                    'success' => true,
                    'message' => 'تم تسجيل الدخول بنجاح',
                    'redirect_url' => route('shop.customers.account.index')
                ]);
            } else {
                // Increment verification attempts
                Cache::put($cacheKey, $verifyAttempts + 1, 1800); // 30 minutes

                return response()->json([
                    'success' => false,
                    'message' => 'رمز التحقق غير صحيح'
                ], 400);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات غير صحيحة',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Phone OTP Verify Error: ' . $e->getMessage(), [
                'phone' => $request->phone ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء التحقق. يرجى المحاولة مرة أخرى.'
            ], 500);
        }
    }

    /**
     * Resend OTP with additional checks
     */
    public function resendPhoneOtp(Request $request)
    {
        // Add a small delay to prevent spam
        sleep(2);

        return $this->sendPhoneOtp($request);
    }

    /**
     * Destroy the customer session (logout).
     */
    public function destroy()
    {
        auth()->guard('customer')->logout();

        return redirect()->route('shop.home.index');
    }

    /**
     * Format phone number to standard format
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters except +
        $phone = preg_replace('/[^0-9+]/', '', $phone);

        // Handle different input formats
        if (str_starts_with($phone, '+')) {
            return $phone; // Already in correct format
        } elseif (str_starts_with($phone, '00')) {
            return '+' . substr($phone, 2); // Remove 00 and add +
        } elseif (str_starts_with($phone, '966')) {
            return '+' . $phone; // Add + to country code
        } elseif (str_starts_with($phone, '05')) {
            return '+966' . substr($phone, 1); // Saudi format 05XXXXXXXX
        } elseif (strlen($phone) === 9 && str_starts_with($phone, '5')) {
            return '+966' . $phone; // Saudi format 5XXXXXXXX
        } elseif (strlen($phone) === 8) {
            // For other Gulf countries, assume Saudi if starts with 5
            if (str_starts_with($phone, '5')) {
                return '+966' . $phone;
            }
        }

        // Default to Saudi if we can't determine
        return '+966' . ltrim($phone, '0');
    }

    /**
     * Create a new customer with phone number
     */
    private function createPhoneCustomer(string $phone): Customer
    {
        return Customer::create([
            'first_name' => 'عميل',
            'last_name' => 'جديد',
            'email' => $this->generateTempEmail($phone),
            'phone' => $phone,
            'password' => Hash::make(Str::random(16)),
            'customer_group_id' => 1, // Default customer group ID
            'channel_id' => 1, // Default channel ID  
            'is_verified' => false,
            'phone_verified' => false,
            'status' => 1,
        ]);
    }

    /**
     * Generate temporary email for phone-only customers
     */
    private function generateTempEmail(string $phone): string
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        return $cleanPhone . '@temp.phone.local';
    }

    /**
     * Get country information from phone number
     */
    private function getCountryFromPhone(string $phone): array
    {
        $countries = [
            '+966' => ['code' => 'sa', 'name' => 'Saudi Arabia'],
            '+965' => ['code' => 'kw', 'name' => 'Kuwait'],
            '+973' => ['code' => 'bh', 'name' => 'Bahrain'],
            '+974' => ['code' => 'qa', 'name' => 'Qatar'],
            '+971' => ['code' => 'ae', 'name' => 'UAE'],
            '+968' => ['code' => 'om', 'name' => 'Oman'],
        ];

        foreach ($countries as $code => $info) {
            if (str_starts_with($phone, $code)) {
                return $info;
            }
        }

        return ['code' => 'sa', 'name' => 'Saudi Arabia']; // Default
    }

    /**
     * Send OTP via WhatsApp
     */
private function sendWhatsAppOtp(Customer $customer, string $otp): bool 
{
    try {
        $whatsappConfig = config('services.whatsapp');
        
        if (!$whatsappConfig || !$whatsappConfig['enabled']) {
            Log::info("OTP for testing: {$otp} to {$customer->phone}");
            return true;
        }

        // إرسال البيانات للتدفق الجديد في Widers
        $payload = [
            'phone' => $customer->phone,
            'otp' => $otp,
            'customer_name' => $customer->name ?? 'عزيزنا العميل',
        ];

        Log::info('Sending OTP to Widers OTP Flow', [
            'customer_id' => $customer->id,
            'phone' => $customer->phone,
            'payload' => $payload
        ]);

        // استخدم webhook URL الخاص بالتدفق الجديد
        $otpFlowWebhook = config('services.whatsapp.otp_webhook_url');
        
        $response = Http::timeout(30)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => 'Laravel-App/1.0',
            ])
            ->post($otpFlowWebhook, $payload);

        // تسجيل الرد الكامل للمتابعة
        Log::info('Widers OTP Flow Response', [
            'status_code' => $response->status(),
            'response_headers' => $response->headers(),
            'response_body' => $response->body(),
            'customer_id' => $customer->id,
        ]);

        if ($response->successful()) {
            Log::info('OTP sent successfully via Widers OTP Flow', [
                'customer_id' => $customer->id,
                'phone' => $customer->phone,
                'response_status' => $response->status()
            ]);
            return true;
        }

        // إذا فشل، جرب التنسيق البديل
        if ($response->status() >= 400) {
            Log::warning('First attempt failed, trying alternative format', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return $this->tryAlternativeOtpFormat($customer, $otp, $otpFlowWebhook);
        }

        Log::error('Failed to send OTP via Widers OTP Flow', [
            'customer_id' => $customer->id,
            'phone' => $customer->phone,
            'response_status' => $response->status(),
            'response_body' => $response->body()
        ]);

        return false;

    } catch (\Exception $e) {
        Log::error('Widers OTP Flow exception', [
            'customer_id' => $customer->id ?? null,
            'phone' => $customer->phone ?? null,
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
        return false;
    }
}
    /**
     * Send welcome message after successful login
     */
    private function sendWelcomeMessage(Customer $customer): void
    {
        try {
            $message = $customer->wasRecentlyCreated
                ? "تم إنشاء حسابك الجديد بنجاح! مرحباً بك في " . config('app.name')
                : "مرحباً بك في " . config('app.name') . "! تم تسجيل دخولك بنجاح.";

            $whatsappConfig = config('services.whatsapp');

            if ($whatsappConfig && $whatsappConfig['enabled']) {
                Http::timeout(10)
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . $whatsappConfig['token'],
                        'Content-Type' => 'application/json',
                    ])
                    ->post($whatsappConfig['api_url'] . '/send-message', [
                        'phone' => $customer->phone,
                        'message' => $message,
                        'type' => 'text'
                    ]);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to send welcome message', [
                'customer_id' => $customer->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
