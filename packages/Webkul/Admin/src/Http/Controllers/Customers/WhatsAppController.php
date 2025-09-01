<?php

namespace Webkul\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Customer\Models\WhatsAppMessageLog;
use Webkul\Customer\Services\WhatsAppService;

class WhatsAppController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(protected WhatsAppService $whatsAppService)
    {
    }

    /**
     * Display WhatsApp dashboard with statistics
     */
    public function index(Request $request)
    {
        $days = $request->get('days', 30);
        
        $stats = $this->whatsAppService->getMessageStats($days);
        
        $recentMessages = WhatsAppMessageLog::with('customer')
            ->latest()
            ->limit(50)
            ->get();

        return view('admin::whatsapp.index', compact('stats', 'recentMessages', 'days'));
    }

    /**
     * Display customer interactions
     */
    public function customerInteractions(Request $request)
    {
        $customerId = $request->get('customer_id');
        $phone = $request->get('phone');
        
        $query = WhatsAppMessageLog::with('customer');
        
        if ($customerId) {
            $query->where('customer_id', $customerId);
        }
        
        if ($phone) {
            $query->where('phone', 'like', '%' . $phone . '%');
        }
        
        $interactions = $query->latest()->paginate(20);

        return view('admin::whatsapp.interactions', compact('interactions'));
    }

    /**
     * Send promotional message to customers
     */
    public function sendPromotional(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'customer_group' => 'required|in:all,verified,recent',
        ]);

        // Get target customers based on group
        $customers = $this->getTargetCustomers($request->customer_group);
        
        $sent = 0;
        $failed = 0;

        foreach ($customers as $customer) {
            if ($customer->phone) {
                $success = $this->whatsAppService->sendPromotionalMessage(
                    $customer->phone, 
                    $request->message
                );
                
                $success ? $sent++ : $failed++;
            }
        }

        return back()->with('success', "رسائل ترويجية تم إرسالها: {$sent}, فشلت: {$failed}");
    }

    /**
     * Get target customers for promotional messages
     */
    protected function getTargetCustomers(string $group)
    {
        $query = \Webkul\Customer\Models\Customer::whereNotNull('phone')
            ->where('phone_verified', true);

        switch ($group) {
            case 'verified':
                $query->where('is_verified', true);
                break;
            case 'recent':
                $query->where('created_at', '>=', now()->subDays(30));
                break;
        }

        return $query->get();
    }
}