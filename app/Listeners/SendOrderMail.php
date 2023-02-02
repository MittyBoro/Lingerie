<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPaid as OrderPaidMailMail;
use App\Models\Prop;

class SendOrderMail implements ShouldQueue
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
     * @param  \App\Events\OrderPaid  $event
     * @return void
     */
    public function handle(OrderPaid $event)
    {
        $order = $event->order;

        $defaultEmail = Prop::findByKey('mail_to') ?: config('mail.to');
        $customerEmail = $order->email;

        Mail::to($defaultEmail)->locale($order->lang)->send(new OrderPaidMailMail($order));
        sleep(1);
        Mail::to($customerEmail)->locale($order->lang)->send(new OrderPaidMailMail($order));
    }

}
