<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Prop;
use App\Models\FeedbackOrder;

class FeedbackOrderSend extends Mailable
{
    use Queueable, SerializesModels;

    public $props;
    public $order;
    public $subject;

    public function __construct(FeedbackOrder $order)
    {
        $this->props = Prop::list();
        $this->order = $order;

        $this->subject = "«{$this->order->form_name}» – новая заявка";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.feedback_orders');
    }
}
