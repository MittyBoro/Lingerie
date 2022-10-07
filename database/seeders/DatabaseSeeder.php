<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\FeedbackOrder;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Product\Product;
use App\Models\Product\ProductOrder;
use App\Models\Product\ProductOrderItem;
use App\Models\Product\PromoCode;
use App\Models\Prop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{

    use WithoutModelEvents;

    private $loadFiles = true;

    private $data;

    public function run()
    {
        $this->setUsers($this->data->get('users'));
        $this->setCategories($this->data->get('categories'));
        $this->setProps($this->data->get('props'));
        $this->setPages($this->data->get('pages'));
        $this->setProducts($this->data->get('products'));
        $this->setProductOrders($this->data->get('product_orders'));
        $this->setProductOrderItems($this->data->get('product_order_items'));
        $this->setFeedbackOrders($this->data->get('feedback_orders'));
    }

    private function setUsers(Collection $data)
    {
        $data->each(function($item) {
            $item['password'] = 'password';
            User::create($item);
        });
    }

    private function setCategories(Collection $data)
    {
        $data->each(function($item) {
            $item['model_type'] = Product::class;
            Category::create($item);
            Category::fixTree();
        });
    }

    private function setProps(Collection $data)
    {
        $data->each(function($item) {

            $created = app(Prop::class)->create(\Arr::except([...$item], 'value'));

            if (!$this->loadFiles && in_array($item['type'], ['file', 'files'])) {
                return;
            }

            $created->updateItem( [ 'admin_value' => $item['value'] ] );
        });
    }

    private function setPages(Collection $data)
    {
        $data->each(function($item) {

            $createData = \Arr::except($item, ['props', 'user_id', 'deleted_at']);
            $created = Page::create($createData);

            $props = collect($item['props'])->map(function($s) use ($created) {
                $s['model_type'] = $created::class;
                $s['model_id'] = $created->id;

                return $s;
            });

            $this->setProps($props);
        });
    }

    private function setProducts(Collection $data)
    {
        $data->each(function($item) {
            $createData = \Arr::except($item, ['category_id', 'categories', 'gallery', 'variations']);

            $product = Product::create($createData);

            $data = \Arr::only($item, ['categories', 'variations', 'gallery']);

            if (!$this->loadFiles) {
                $data = \Arr::except($data, ['gallery']);
            }

            $product->saveRelations($data);
        });
    }


    private function setProductOrders(Collection $data)
    {
        $data->each(function($item) {
            ProductOrder::create($item);
        });
    }

    private function setProductOrderItems(Collection $data)
    {
        $data->each(function($item) {
            ProductOrderItem::create($item);
        });
    }

    private function setFeedbackOrders(Collection $data)
    {
        $data->each(function($item) {
            FeedbackOrder::create($item);
        });
    }
}
