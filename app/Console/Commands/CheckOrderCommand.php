<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\Payment\PaymentService;
use Illuminate\Console\Command;

class CheckOrderCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:check';

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
                        ->where( 'created_at', '<=', now()->subMinutes(5))
                        ->latest()
                        ->get();

        $ordres->each(function (Order $order) {
            $payemnt = PaymentService::set($order);
            $payemnt->check();
        });
    }

}
