<?php

namespace Webkul\Customer\Services;

use Webkul\Customer\Models\Customer;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Webkul\Customer\Models\Order;
use Webkul\Customer\Services\WhatsAppService;

class OtpService
{
    /**
     * Send OTP via WhatsApp using Widers API
     * 
     * @param Customer $customer
     * @param string $otp
     * @return bool Success status
     */
    public function sendOtpViaWhatsApp(Customer $customer, string $otp): bool
    {
        try {
            $message = trans('customer::app.customers.otp.message', [
                'otp' => $otp,
                'name' => $customer->name,
                'minutes' => 5
            ]);

            $response = Http::withToken(config('whatsapp.widers_token'))
                ->post(config('whatsapp.widers_api_url') . '/send-message', [
                    'phone' => $customer->phone,
                    'message' => $message,
                    'type' => 'text'
                ]);

            if ($response->successful()) {
                Log::info('OTP sent successfully via WhatsApp', [
                    'customer_id' => $customer->id,
                    'phone' => $customer->phone
                ]);
                return true;
            }

            Log::error('Failed to send OTP via WhatsApp', [
                'customer_id' => $customer->id,
                'phone' => $customer->phone,
                'response' => $response->body()
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to send order shipped notifications', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle order canceled event
     * 
     * @param Order $order
     * @return void
     */
    public function orderCanceled(Order $order): void
    {
        try {
            if ($order->customer && $order->customer->phone) {
                $message = trans('customer::app.orders.whatsapp.canceled', [
                    'order_id' => $order->increment_id,
                    'customer_name' => $order->customer_full_name,
                ]);

                $this->whatsAppService->sendMessage($order->customer->phone, $message);
            }

        } catch (\Exception $e) {
            Log::error('Failed to send order canceled notifications', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Notify store manager about new order
     * 
     * @param Order $order
     * @return void
     */
    protected function notifyStoreManager(Order $order): void
    {
        $managerPhone = core()->getConfigData('whatsapp.manager_phone');
        
        if ($managerPhone) {
            $message = trans('admin::app.orders.whatsapp.new-order-notification', [
                'order_id' => $order->increment_id,
                'customer_name' => $order->customer_full_name,
                'total' => core()->formatPrice($order->grand_total),
                'items_count' => $order->items->count(),
                'phone' => $order->customer?->phone ?? 'N/A'
            ]);

            $this->whatsAppService->sendMessage($managerPhone, $message);
        }
    }
}