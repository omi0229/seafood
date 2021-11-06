<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    public function getCartId()
    {
        return Str::uuid();
    }

    public function getCartCount(Request $request)
    {
        return response()->Json(Cart::where('cart_id', $request->all()['cart_id'])->count());
    }

    public function showCart(Request $request)
    {
        $data = data_get($request->all(), 'cart_id') ? Cart::with(['product_specification' => function ($query) { $query->with(['product']); }])->where('cart_id', $request->all()['cart_id'])->get() : [];
        return CartResource::collection($data)->toResponse(app('request'))->getData(true);
    }

    public function addCart(Request $request)
    {
        $inputs = $request->all();
        $items = Cart::where('cart_id', $inputs['cart_id'])->where('specifications_id', $inputs['specifications_id']);
        if ($items->count() > 0) {
            $data = $items->first();
            $data->count += $inputs['count'];
            $data->save();
        } else {
            Cart::create($inputs);
        }

        return response()->Json(['status' => true, 'message' => '加入購物車成功']);
    }
}
