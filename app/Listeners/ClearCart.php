<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ClearCart
{

    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderPaid  $event
     * @return void
     */
    public function handle(OrderPaid $event)
    {
        if ($event->order->cart_id) {
            Cart::clearById($event->order->cart_id);
        }
    }
}
