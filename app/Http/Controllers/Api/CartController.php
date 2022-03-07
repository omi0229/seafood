<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Http\Resources\CartResource;
use App\Services\ShoppingCartServices;
use App\Repositories\CartRepository;

class CartController extends Controller
{
    public function getCartId()
    {
        return Str::uuid();
    }

    public function getCartCount(Request $request, ShoppingCartServices $services)
    {
        # 檢查購物車有沒有被下架的商品
        $services->authCartContent($request->all()['cart_id']);

        return response()->Json(Cart::where('cart_id', $request->all()['cart_id'])->count());
    }

    public function showCart(Request $request)
    {
        $data = data_get($request->all(), 'cart_id') ? Cart::with(['product_specification.product'])->where('cart_id', $request->all()['cart_id'])->get() : [];
        return CartResource::collection($data)->toResponse(app('request'))->getData(true);
    }

    public function addCart(Request $request)
    {
        $inputs = $request->all();
        $items = Cart::where('cart_id', $inputs['cart_id'])->where('specifications_id', $inputs['specifications_id']);
        if ($items->count() > 0) {
            $data = $items->first();
            $data->count += $inputs['count'];

            if ($data->count > 9999) {
                $data->count = 9999;
            }

            $data->save();
        } else {
            Cart::create($inputs);
        }

        return response()->Json(['status' => true, 'message' => '加入購物車成功']);
    }

    public function RemoveCartProduct($id)
    {
        Cart::find(Cart::decodeSlug($id))->delete();
        return response()->Json(['status' => true, 'message' => '移除商品成功']);
    }

    public function RemoveCartAllProduct($uu_id)
    {
        Cart::where('cart_id', $uu_id)->delete();
        return response()->Json(['status' => true, 'message' => '已清空購物車']);
    }

    # 重新加入購物車
    public function buyAgain(Request $request, CartRepository $repository)
    {
        $inputs = $request->all();
        if (data_get($inputs, 'order_id') && data_get($inputs, 'cart_id')) {
            $repository->buyAgain($inputs['order_id'], $inputs['cart_id']);
            return response()->Json(['status' => true, 'message' => 'success']);
        }

        return response()->Json(['status' => false, 'message' => '無此訂單']);
    }
}
