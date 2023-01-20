<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\FAQ;
use App\Models\FeedbackOrder;
use App\Models\Page;
use App\Models\Product\ProductOrder;
use App\Models\Product\ProductOrderItem;
use App\Models\Prop;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        // $this->factories();

        $this->call([
            // ProductSeeder::class,
            PageSeeder::class,
        ]);
    }

    private function factories() {

		User::factory(8)->create();
		Prop::factory(40)->create();
        // Page::factory(5)->create();
		FAQ::factory(5)->create();
		Translation::factory(20)->create();
    }


}
