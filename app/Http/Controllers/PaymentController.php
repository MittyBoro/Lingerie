<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class PaymentController extends Controller
{

    public function webhook(Request $request, $paymentType)
    {
        if ( !in_array( $paymentType, array_keys(config('payment.drivers')) ) ) {
            abort(403);
        }
        $payemnt = PaymentService::set(null, $paymentType);

        return $payemnt->webhook();
    }

}
