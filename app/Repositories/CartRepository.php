<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\ProductSpecifications;
use App\Repositories\OrderRepository;


class CartRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Cart';
    }

    public function buyAgain($order_id, $cart_id): void
    {
        $model = app()->make($this->model());
        
        $repository = new OrderRepository;
        $order = $repository->info($order_id);
        if (count($order->order_products) > 0) {
            foreach ($order->order_products as $product) {
                $product->load(['product_specifications.product.put_ons']);
                if ($product->product_specifications->inventory > 0 && $product->product_specifications->product->put_ons->where('status', '!=', 0)->count() > 0) {
                    $items = $model::where('cart_id', $cart_id)->where('specifications_id', $product->product_specifications->id);
                    if ($items->count() === 0) {
                        $model::create(['cart_id' => $cart_id, 'specifications_id' => $product->product_specifications->id, 'count' => 1]);
                    }
                }
            }
        }
    }

    public function changeCount($data)
    {
        if (!(isset($data['cart_id']) && isset($data['list']) && is_array($data['list']))) {
            return false;
        }

        $model = app()->make($this->model());
        $list = $data['list'];
        foreach ($list as $info) {
            $items = $model::where('cart_id', $data['cart_id'])->where('specifications_id', ProductSpecifications::decodeSlug($info['specifications_id']));
            if ($items->count() > 0) {
                $data = $items->first();
                $data->count = $info['count'];

                if ($data->count > 9999) {
                    $data->count = 9999;
                }

                $data->save();
            }
        }

        return true;
    }
}
