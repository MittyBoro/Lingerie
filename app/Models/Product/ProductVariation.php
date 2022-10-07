<?php

namespace App\Models\Product;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;

class ProductVariation extends BaseModel
{
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('default_order_by', function (Builder $builder){
            $builder->orderBy( 'position', 'asc' );
        });
    }

    public function promo_code_prices()
    {
        return $this->hasMany(ProductVariationPromoCode::class);
    }

    public function getForCartAttribute()
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'value' => $this->value,
            'price' => $this->price,
            'bonuses' => $this->bonuses,
        ];
    }

    public function massSync($variations, $product_id)
    {
        $ids = pluck_not_null($variations, 'id');

        self::whereNotIn('id', $ids)
            ->where('product_id', $product_id)
            ->delete();

        $promocodes = [];
        $nullifyVariations = [];

        foreach( $variations as $k => $v )
        {
            $variations[$k] = [
                'product_id' => $product_id,
                'id' => $v['id'] ?? null,
                'name' => $v['name'],
                'value' => $v['value'],
                'price' => $v['price'],
                'bonuses' => $v['bonuses'],
                'position' => $k,
            ];

            if ( !(int)$v['price'] && isset($v['id']) && $v['id'] )
                $nullifyVariations[] = $v['id'];

            if ( isset($v['promo_code_prices']) && !empty($v['promo_code_prices']) )
                $promocodes[$k] = $v['promo_code_prices'];
        }
        self::upsert($variations, ['id'], ['name', 'value', 'price', 'bonuses', 'position']);

        $this->savePromoCodes($promocodes, $product_id);
    }


    private function savePromoCodes($promocodes, $product_id)
    {
        $positions = array_keys($promocodes);

        $variations = ProductVariation::whereIn('position', $positions)
                            ->where('product_id', $product_id)
                            ->get(['id', 'position', 'price']);

        $promoPrices = [];
        foreach($variations as $item)
        {
            foreach($promocodes[$item->position] as $v)
            {
                if (!$v) continue;

                $price = $v['price'] > 0 ? $v['price'] : $v['price'] + $item->price;
                $promoPrices[] = [
                    'product_variation_id' => $item->id,
                    'promo_code_id' => $v['promo_code_id'],
                    'price' => $price,
                ];
            }
        };

        $this->promo_code_prices()
            ->upsert($promoPrices, ['product_variation_id', 'promo_code_id'], ['price']);
    }

}

