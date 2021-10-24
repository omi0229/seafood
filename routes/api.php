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
Route::post('cart/show-cart', [CartController::class, 'showCart']);
Route::post('cart/add-cart', [CartController::class, 'addCart']);

# 大圖輪播
Route::get('banners/list', [BannersController::class, 'list']);

# 最新消息
Route::get('news-type/list/{page}', [NewsTypeController::class, 'list']);
Route::get('news/{type_id?}/{page?}', [NewsController::class, 'list']);
Route::get('news-info/{id}', [NewsController::class, 'info']);

# 烹飪教學
Route::get('cooking-type/list/{page}', [CookingTypeController::class, 'list']);
Route::get('cooking/{type_id?}/{page?}', [CookingController::class, 'list']);

# 線上購物
Route::get('directory/list/{page}', [DirectoryController::class, 'list']);
Route::get('product/{type_id}/{page?}', [PutOnController::class, 'list']);
Route::get('product-info/{id}', [PutOnController::class, 'info']);

Route::middleware(['auth:api'])->group(function () {
    ### 會員中心
    # 編輯會員
    Route::post('member/update', [MemberController::class, 'update']);
    # 變更密碼
    Route::post('member/change-password', [MemberController::class, 'changePassword']);
});
