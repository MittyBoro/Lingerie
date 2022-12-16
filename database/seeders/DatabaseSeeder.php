<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\FAQ;
use App\Models\FeedbackOrder;
use App\Models\Page;
use App\Models\Product\Product;
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

		// Category::factory(15)->create();

		// PromoCode::factory(3)->create();

		// // с файлами
		// Product::factory(110)->create();

		// Partner::factory(90)->create();

		// Prop::factory(15)->create();

    }

}
