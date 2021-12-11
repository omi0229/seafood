<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

### 簡訊驗證碼
# 發送驗證碼
Route::post('auth/set-sms-code', [AuthController::class, 'setSmsCode']);
# 驗證驗證碼
Route::post('auth/auth-sms-code', [AuthController::class, 'authSmsCode']);
# 會員登入
Route::post('auth/login', [AuthController::class, 'login']);

# 新增會員
Route::post('member/insert', [MemberController::class, 'insert']);
# 忘記密碼
Route::post('member/forget', [MemberController::class, 'forget']);

# 購物車
Route::get('cart/get-cart-id', [CartController::class, 'getCartId']);
Route::post('cart/get-cart-count', [CartController::class, 'getCartCount']);
Route::post('cart/add-cart', [CartController::class, 'addCart']);

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
Route::get('menu', function () {
    $array = [
        'news_types_list' => (new \App\Repositories\NewsTypesRepository)->list('all'),
        'cooking_types_list' => (new \App\Repositories\CookingTypesRepository)->list('all'),
        'directory_list' => (new \App\Repositories\DirectoryRepository)->apiMenu(),
    ];

    return response()->JSON($array);
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

    ### 會員中心
    # 編輯會員
    Route::post('member/update', [MemberController::class, 'update']);
    # 變更密碼
    Route::post('member/change-password', [MemberController::class, 'changePassword']);
    # 取得會員通知
    Route::get('member/notification/{member_id}', [MemberController::class, 'notification']);
});
