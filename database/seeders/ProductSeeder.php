<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->runAttributes();
        ProductCategory::factory(15)->create();
		Product::factory(30)->create();
    }

    private function runAttributes()
    {
        $insertSizes = array_map(fn ($value) => [
            'type' => 'size',
            'value' => $value,
        ], ['XS', 'S', 'M', 'L', 'XL', 'XXL']);


        $colorList = [
            ['red', '#f00'],
            ['green', '#0f0'],
            ['blue', '#00f'],
            ['white', '#fff'],
            ['black', '#000'],
            ['gray', '#888'],
        ];

        $insertColors = array_map(fn ($value) => [
            'type' => 'color',
            'value' => $value[0],
            'extra' => $value[1],
        ], $colorList);

        ProductAttribute::insert($insertSizes);
        ProductAttribute::insert($insertColors);
    }
}
