<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\ProductOption;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->runOptions();
		Product::factory(25)->create();
    }

    private function runOptions()
    {
        $insertSizes = array_map(fn ($value) => [
            'type' => 'size',
            'value' => $value,
        ], ['XS', 'S', 'M', 'L', 'XL', 'XXL']);


        $colorList = [
            ['red', 'background: #f00'],
            ['green', 'background: #0f0'],
            ['blue', 'background: #00f'],
            ['white', 'background: #fff; border: 1px solid #D9D9D9;'],
            ['black', 'background: #000'],
            ['gray', 'background: #888'],
        ];

        $insertColors = array_map(fn ($value) => [
            'type' => 'color',
            'value' => $value[0],
            'extra' => $value[1],
        ], $colorList);

        ProductOption::insert($insertSizes);
        ProductOption::insert($insertColors);
    }
}
