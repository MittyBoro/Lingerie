<?php

namespace App\Listeners\Cart;

use App\Events\ProductOrderPaid;
use App\Models\Bonus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ClearUserCart
{

    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProductOrderPaid  $event
     * @return void
     */
    public function handle(ProductOrderPaid $event)
    {
		if ($event->order->user_id) {
			\Cart::session($event->order->user_id)->clear();
		}
    }
}
