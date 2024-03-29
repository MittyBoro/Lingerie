<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\FAQ;
use App\Models\Page;
use App\Models\ProductCategory;
use App\Models\Prop;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->factories();

        $this->call([
            PageSeeder::class,
            PropSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
        ]);
    }

    private function factories()
    {
		// User::factory(8)->create();
		// Prop::factory(40)->create();
        // Page::factory(5)->create();
        // ProductCategory::factory(15)->create();
		FAQ::factory(5)->create();
		// Translation::factory(20)->create();
    }


}
