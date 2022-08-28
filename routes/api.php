<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\NewsTypeController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\CookingTypeController;
use App\Http\Controllers\Api\CookingController;
use App\Http\Controllers\Api\DirectoryController;
use App\Http\Controllers\Api\PutOnController;
use App\Http\Controllers\Api\BannersController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\DiscountCodeController;
use App\Http\Controllers\Api\CouponController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

# 網站基本設定
Route::get('config', function () {
    return response()->JSON(Cache::remember('config_list', Carbon::now()->addMinutes(2), function () {
        return \App\Models\Config::select(['config_name', 'config_value'])->where(function ($query) {
            $query->where('config_name', '!=', 'sms_account');
            $query->where('config_name', '!=', 'sms_password');
            $query->where('config_name', '!=', 'goldflow_MerchantID');
            $query->where('config_name', '!=', 'goldflow_HashKey');
            $query->where('config_name', '!=', 'goldflow_HashIV');
        })->get();
    }));
});

### 簡訊驗證碼
# 發送驗證碼
Route::post('auth/set-sms-code', [AuthController::class, 'setSmsCode']);
# 驗證驗證碼
Route::post('auth/auth-sms-code', [AuthController::class, 'authSmsCode']);
# 會員登入
Route::post('auth/login', [AuthController::class, 'login']);

# 新增會員
Route::post('member/insert', [MemberController::class, 'insert']);
# 驗證註冊手機
Route::get('member/auth-register-cellphone/{cellphone}', [MemberController::class, 'authRegisterCellphone']);
# 忘記密碼
Route::post('member/forget', [MemberController::class, 'forget']);

# 購物車
Route::get('cart/get-cart-id', [CartController::class, 'getCartId']);
Route::post('cart/get-cart-count', [CartController::class, 'getCartCount']);
Route::post('cart/add-cart', [CartController::class, 'addCart']);
Route::post('cart/refresh-cart', [CartController::class, 'refreshCart']);

# 線上購物、烹飪教學 搜尋
Route::get('search/all/{keyword}', function ($keywords) {
    return response()->JSON([
        'cooking' => (new \App\Repositories\CookingRepository)->searchList(1, $keywords),
        'product' => (new \App\Repositories\PutOnRepository)->searchList(1, $keywords),
    ]);
});
# 烹飪教學 搜尋
Route::get('search/cooking/{keyword}/{page}', function ($keywords, $page) {
    return response()->JSON((new \App\Repositories\CookingRepository)->searchList($page, $keywords));
});
# 線上購物 搜尋
Route::get('search/product/{keyword}/{page}', function ($keywords, $page) {
    return response()->JSON((new \App\Repositories\PutOnRepository)->searchList($page, $keywords));
});

# RWD 滑出式選單內容
Route::get('menu/{type}', function ($type) {
    return Cache::remember($type . '_list', Carbon::now()->addMinutes(3), function () use ($type) {
        switch ($type) {
            case 'news':
                return (new \App\Repositories\NewsTypesRepository)->list('all');
            case 'cooking':
                return (new \App\Repositories\CookingTypesRepository)->list('all');
            case 'directory':
                return (new \App\Repositories\DirectoryRepository)->apiMenu();
        }
    });
});

# 大圖輪播
Route::get('banners/list', [BannersController::class, 'list']);

# 關於海龍王, 購物說明
Route::get('pages/{type}', [PagesController::class, 'info']);

# 最新消息
Route::get('news-type/list/{page}', [NewsTypeController::class, 'list']);
Route::get('news/{type_id?}/{page?}', [NewsController::class, 'list']);
Route::get('news-info/{id}', [NewsController::class, 'info']);

# 烹飪教學
Route::get('cooking-type/list/{page}', [CookingTypeController::class, 'list']);
Route::get('cooking/{type_id?}/{page?}', [CookingController::class, 'list']);

# 線上購物
Route::get('directory/menu', [DirectoryController::class, 'menu']);
Route::get('directory/list/{page}', [DirectoryController::class, 'list']);
Route::get('product/{type_id}/{page?}', [PutOnController::class, 'list']);
Route::get('product-info/{id}', [PutOnController::class, 'info']);
Route::get('put-on-random/{directories_id}/{count?}', [PutOnController::class, 'putOnRandom']);

# 前台首頁顯示一筆優惠劵
Route::get('coupon/get/{cart_id}/{member_id?}', [CouponController::class, 'get']);

Route::middleware(['auth:member_api'])->group(function () {
    ### 購物車
    # 取得購物車資料
    Route::post('cart/show-cart', [CartController::class, 'showCart']);
    # 刪除購物車單筆資料
    Route::delete('cart/remove-cart-product/{id}', [CartController::class, 'RemoveCartProduct']);
    # 刪除購物車所有資料
    Route::delete('cart/remove-cart-all-product/{uu_id}', [CartController::class, 'RemoveCartAllProduct']);

    ### 訂單
    # 取得運費列表
    Route::get('order/freight', [OrderController::class, 'freight']);
    # 建立訂單
    Route::post('order/create', [OrderController::class, 'create']);
    # 查詢所有訂單
    Route::get('order/list/{member_id}/{page}', [OrderController::class, 'list']);
    # 查詢單筆訂單
    Route::get('order/info/{order_id}', [OrderController::class, 'info']);
    # 付款
    Route::post('order/payment', [OrderController::class, 'payment']);
    # 取得 金流串接URL
    Route::get('order/get/payment_url', function () {
        return env('ECPAY.PAYMENT_URL');
    });
    # 查詢優惠代碼
    Route::post('discount-code/search', [DiscountCodeController::class, 'search']);

    ### 會員中心
    # 編輯會員
    Route::post('member/update', [MemberController::class, 'update']);
    # 變更密碼
    Route::post('member/change-password', [MemberController::class, 'changePassword']);
    # 取得會員通知
    Route::get('member/notification/{member_id}', [MemberController::class, 'notification']);
    # 前台首頁優惠劵領取
    Route::post('member/get-coupon', [MemberController::class, 'getCoupon']);
    # 前台首頁優惠劵領取
    Route::get('member/coupon-list/{member_id}/{used?}', [MemberController::class, 'couponList']);
    # 這次購物可使用的優惠劵
    Route::post('member/coupon-use', [MemberController::class, 'couponUse']);

    ### 購物車
    # 再次購買
    Route::post('cart/buy-again', [CartController::class, 'buyAgain']);
});
