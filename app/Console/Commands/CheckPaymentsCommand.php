<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\Payment\Payment;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckPaymentsCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверка ожидаемых платежей';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ordres = Order::where('status', Order::STATUS_PENDING)
                        ->where( 'created_at', '<=', Carbon::now()->subMinutes(5))
                        ->latest()
                        ->get();

        // dd($ordres->count());

        $ordres->each(function (Order $order) {
            $this->updateStatus($order);
        });
    }

    private function updateStatus($order)
    {
        $payment = new Payment($order->payment_type);
        $payment->updateStatus($order);
    }
}
