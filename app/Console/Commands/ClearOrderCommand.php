<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class ClearOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удалить неоплаченные заказы';

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
        Order::where('status', Order::STATUS_CANCELED)
                    ->where( 'created_at', '<=', now()->subDays(30))
                    ->get()
                    ->each->delete();
    }
}
