<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Prop;
use App\Models\Order;

class OrderPaid extends Mailable
{
    use Queueable, SerializesModels;

    public $props;
    public $order;
    public $subject;

    public function __construct(Order $order)
    {
        $this->props = Prop::list();
        $this->order = $order;

        $this->subject = trans('front.order_accepted');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.order', [
                        'bgColor' => '#FFF2F0',
                        'primaryColor' => '#DEA19A',
                        'secondaryColor' => '#8D9041',
                    ]);
    }
}
