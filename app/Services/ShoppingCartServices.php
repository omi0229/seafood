<?php

namespace App\Services;

use Illuminate\Http\Request;

class ShoppingCartServices
{
    static $model = 'App\Models\Cart';

    public function authCartContent($cart_id)
    {
        $model = app()->make(self::$model);
        $data = $model::with(['product_specification.product.put_ons' => function($query) {
            $query->where('status', '!=', 0);
        }])->where('cart_id', $cart_id)->get();
        foreach ($data as $item) {
            if($item->product_specification && $item->product_specification->product && $item->product_specification->product->put_ons){
                $count = $item->product_specification->product->put_ons->count();
                if($count <= 0) {
                    $item->delete();
                }
            }
        }
    }
}
