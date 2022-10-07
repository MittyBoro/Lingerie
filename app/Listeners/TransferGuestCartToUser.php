<?php

namespace App\Listeners;

use Cart;
use Illuminate\Auth\Events\Login;

class TransferGuestCartToUser
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
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $guestCartItems = Cart::getContent();

        Cart::clear();
        Cart::clearCartConditions();

        $userCart = Cart::session($event->user->id);

        if ($guestCartItems->isNotEmpty())
            $userCart->add($guestCartItems->toArray());
    }
}
