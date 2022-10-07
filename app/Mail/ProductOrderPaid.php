<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Prop;
use App\Models\Product\ProductOrder;

class ProductOrderPaid extends Mailable
{
    use Queueable, SerializesModels;

    public $props;
    public $order;
    public $subject;

    public function __construct(ProductOrder $order, $toCustomer)
    {
        $this->props = Prop::list();
        $this->order = $order;

        if ( $toCustomer )
            $this->subject = "Ваш заказ принят в обработку";
        else
            $this->subject = "Оплачен новый заказ";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.product_order');
    }
}
