<?php

namespace App\Listeners\Cart;

use App\Events\ProductOrderPaid;
use App\Models\Bonus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddPaymentBonuses implements ShouldQueue
{

	public $delay = 0;

	public function viaQueue()
	{
        $this->delay = Bonus::getBuyHoursToCharge() * 60*60;
	}

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProductOrderPaid  $event
     * @return void
     */
    public function handle(ProductOrderPaid $event)
    {
		Bonus::appendByOrder($event->order);
    }
}
