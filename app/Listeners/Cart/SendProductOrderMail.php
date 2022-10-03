<?php

namespace App\Listeners\Cart;

use App\Events\ProductOrderPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Mail;
use App\Mail\ProductOrderPaid as ProductOrderPaidMailMail;

class SendProductOrderMail implements ShouldQueue
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  \App\Events\ProductOrderPaid  $event
	 * @return void
	 */
	public function handle(ProductOrderPaid $event)
	{
		$this->sendMailNotify($event->order);
	}

	private function sendMailNotify($order)
	{
		$defaultEmail = config('alevi.mail_to');
		$customerEmail = $order->email;

		Mail::to($defaultEmail)->send(new ProductOrderPaidMailMail($order, false));
		sleep(1);
		Mail::to($customerEmail)->send(new ProductOrderPaidMailMail($order, true));
	}
}
