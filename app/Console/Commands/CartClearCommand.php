<?php

namespace App\Console\Commands;

use App\Services\Cart\Models\CartStorage;
use Illuminate\Console\Command;

class CartClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удалить старые записи в корзине';

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
        CartStorage::whereDate('updated_at', '<', now()->subMonths(12))
                    ->delete();
    }

}
