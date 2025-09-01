<?php

namespace Webkul\Customer\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Webkul\Customer\Listeners\OrderNotificationListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Order created event
        Event::listen('checkout.order.save.after', function ($order) {
            app(OrderNotificationListener::class)->orderCreated($order);
        });

        // Order shipped event
        Event::listen('sales.shipment.save.after', function ($shipment) {
            app(OrderNotificationListener::class)->orderShipped($shipment->order);
        });

        // Order canceled event
        Event::listen('sales.order.cancel.after', function ($order) {
            app(OrderNotificationListener::class)->orderCanceled($order);
        });
    }
}