<?php

namespace App\Console\Commands;

use App\Models\DatabaseStorageModel;
use App\Models\User;
use Illuminate\Console\Command;

class ClearCartCommand extends Command
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
        $this->clearGuestData();
        $this->clearUserData();
    }

    private function clearUserData()
    {
        DatabaseStorageModel::whereDate('updated_at', '<', now()->subDays(180))
                    ->delete();
    }

    private function clearGuestData()
    {
        DatabaseStorageModel::where('id', 'like', 'guest_%')
                    ->whereDate('updated_at', '<', now()->subDays(60))
                    ->delete();
    }
}
