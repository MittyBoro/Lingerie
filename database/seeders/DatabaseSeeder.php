<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\FAQ;
use App\Models\FeedbackOrder;
use App\Models\Page;
use App\Models\Product\ProductOrder;
use App\Models\Product\ProductOrderItem;
use App\Models\Prop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
		User::factory(8)->create();

		Page::factory(5)
            ->create();

		FAQ::factory(5)
            ->create();


        $this->call([ ProductSeeder::class ]);

		// с файлами


		// Prop::factory(15)->create();
    }


}
