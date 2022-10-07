<?php

namespace App\Services\Cart;

use Cart;

use App\Models\Product\Product;
use App\Services\Cart\Traits\BonuseTrait;
use App\Services\Cart\Traits\CartItemTrait;
use App\Services\Cart\Traits\DeliveryTrait;
use App\Services\Cart\Traits\PromoCodeTrait;
use App\Services\Cart\Traits\SimpleMethodsTrait;
use Illuminate\Support\Arr;

class CartService
{
    use BonuseTrait;
    use DeliveryTrait;
    use CartItemTrait;
    use PromoCodeTrait;
    use SimpleMethodsTrait;

    protected $promoCodeInstance;

    public function __construct()
    {
        $this->promoCodeInstance = new PromoCodeService();
    }

    protected function getContent()
    {
        return Cart::getContent();
    }

    public function list()
    {
        $cart = $this->getContent()->take(100)
                    ->map(fn ($item) => $this->getSupplementedItem($item))->values();

        return $cart;
    }

    public function add(array $data)
    {
        $product = Product::find4Cart($data['product_id']);

        $cartId = array_hash(Arr::except($data, ['count']));

        $cartItem = [
            'id' => $cartId,
            'name' => $product->title,
            'quantity' => $data['count'],

            ...$this->arrayForItem($product, $data['variation_ids']),
        ];

        Cart::add($cartItem);

        $this->applyPromoCode4Item(Cart::get($cartId));

        return Cart::getContent()->count();
    }

    public function updateQuantity($cart_id, $quantity)
    {
        Cart::update($cart_id, [
            'quantity' => [
                'relative' => false,
                'value' => $quantity,
            ]
        ]);
        $this->updateCartDelivery();
    }


    public function recalculateCart()
    {
        $ids = Cart::getContent()->map->attributes->pluck('product_id')->unique();

        $products = Product::whereIn('id', $ids)->with('variations')->get();

        Cart::getContent()->each(function($item) use ($products) {

            $product = $products->firstWhere('id', $item->attributes->product_id);

            $variationIds = Arr::pluck($item->attributes['variations'], 'id');

            try {
                $updateData = $this->arrayForItem($product, $variationIds);
                Cart::update($item->id, $updateData);
            } catch (\Throwable $e) {
                Cart::remove($item->id);
            }
        });

        $this->applyPromoCode();
        $this->clearCartBonuses();
    }

    public function creatableList()
    {
        $allowAddBonuses = $this->allowAddBonuses();
        return $this->list()
            ->map(fn ($item) => $this->getCreatableItem($item, $allowAddBonuses))->toArray();
    }

}
