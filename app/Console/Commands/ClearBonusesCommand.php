<?php

namespace App\Console\Commands;

use App\Models\Bonus;
use Illuminate\Console\Command;

class ClearBonusesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bonuses:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаление истекших бонусов';

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
        $res = Bonus::where('end_at', '<', now())
                        ->get()
                        ->each->delete();
    }
}
