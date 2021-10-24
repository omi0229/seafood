<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\NewsTypeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CookingTypeController;
use App\Http\Controllers\CookingController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSpecificationController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\PutOnController;
use App\Http\Controllers\MemberController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('login', [LoginController::class, 'login'])->name('login')->middleware('auth.login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::middleware(['auth.web'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    # 基本設定
    Route::get('basic', [BasicController::class, 'index']);
    Route::get('basic/get', [BasicController::class, 'get']);
    Route::post('basic/set', [BasicController::class, 'set']);

    # 權限管理
    Route::get('role', [RoleController::class, 'index']);
    Route::get('role/count', [RoleController::class, 'count']);
    Route::get('role/list/{page}', [RoleController::class, 'list']);
    Route::post('role/insert', [RoleController::class, 'insert']);
    Route::post('role/update', [RoleController::class, 'update']);
    Route::delete('role/delete', [RoleController::class, 'delete']);
    Route::get('role/permissions', [RoleController::class, 'permissions']);

    # 使用者管理
    Route::get('user', [UserController::class, 'index']);
    Route::get('user/count', [UserController::class, 'count']);
    Route::get('user/list/{page}', [UserController::class, 'list']);
    Route::post('user/insert', [UserController::class, 'insert']);
    Route::post('user/update', [UserController::class, 'update']);
    Route::delete('user/delete', [UserController::class, 'delete']);

    # 簡訊設定
    Route::get('sms', [SmsController::class, 'index']);
    Route::get('sms/get', [SmsController::class, 'get']);
    Route::post('sms/set', [SmsController::class, 'set']);

    # 大圖輪播
    Route::get('banners', [BannersController::class, 'index']);
    Route::get('banners/list', [BannersController::class, 'list']);
    Route::post('banners/insert', [BannersController::class, 'insert']);
    Route::post('banners/update', [BannersController::class, 'update']);
    Route::delete('banners/delete', [BannersController::class, 'delete']);

    # 最新消息分類
    Route::get('news-type', [NewsTypeController::class, 'index']);
    Route::get('news-type/count', [NewsTypeController::class, 'count']);
    Route::get('news-type/list/{page}', [NewsTypeController::class, 'list']);
    Route::post('news-type/insert', [NewsTypeController::class, 'insert']);
    Route::post('news-type/update', [NewsTypeController::class, 'update']);
    Route::delete('news-type/delete', [NewsTypeController::class, 'delete']);

    # 最新消息
    Route::get('news', [NewsController::class, 'index']);
    Route::get('news/count', [NewsController::class, 'count']);
    Route::get('news/list/{page}', [NewsController::class, 'list']);
    Route::post('news/insert', [NewsController::class, 'insert']);
    Route::post('news/update', [NewsController::class, 'update']);
    Route::delete('news/delete', [NewsController::class, 'delete']);

    # 烹飪教學分類
    Route::get('cooking-type', [CookingTypeController::class, 'index']);
    Route::get('cooking-type/count', [CookingTypeController::class, 'count']);
    Route::get('cooking-type/list/{page}', [CookingTypeController::class, 'list']);
    Route::post('cooking-type/insert', [CookingTypeController::class, 'insert']);
    Route::post('cooking-type/update', [CookingTypeController::class, 'update']);
    Route::delete('cooking-type/delete', [CookingTypeController::class, 'delete']);

    # 烹飪教學
    Route::get('cooking', [CookingController::class, 'index']);
    Route::get('cooking/count', [CookingController::class, 'count']);
    Route::get('cooking/list/{page}', [CookingController::class, 'list']);
    Route::post('cooking/insert', [CookingController::class, 'insert']);
    Route::post('cooking/update', [CookingController::class, 'update']);
    Route::delete('cooking/delete', [CookingController::class, 'delete']);

    # 產品分類
    Route::get('product-type', [ProductTypeController::class, 'index']);
    Route::get('product-type/count', [ProductTypeController::class, 'count']);
    Route::get('product-type/list/{page}', [ProductTypeController::class, 'list']);
    Route::post('product-type/insert', [ProductTypeController::class, 'insert']);
    Route::post('product-type/update', [ProductTypeController::class, 'update']);
    Route::delete('product-type/delete', [ProductTypeController::class, 'delete']);

    # 產品管理
    Route::get('product', [ProductController::class, 'index']);
    Route::get('product/count', [ProductController::class, 'count']);
    Route::get('product/list/{page}', [ProductController::class, 'list']);
    Route::post('product/insert', [ProductController::class, 'insert']);
    Route::post('product/update', [ProductController::class, 'update']);
    Route::post('product/check-delete', [ProductController::class, 'checkDelete']);
    Route::delete('product/delete', [ProductController::class, 'delete']);

    # 產品規格
    Route::get('product-specification/list/{id}', [ProductSpecificationController::class, 'list']);
    Route::post('product-specification/insert', [ProductSpecificationController::class, 'insert']);
    Route::post('product-specification/update', [ProductSpecificationController::class, 'update']);
    Route::delete('product-specification/delete', [ProductSpecificationController::class, 'delete']);

    # 目錄管理
    Route::get('directory', [DirectoryController::class, 'index']);
    Route::get('directory/count', [DirectoryController::class, 'count']);
    Route::get('directory/list/{page}', [DirectoryController::class, 'list']);
    Route::post('directory/insert', [DirectoryController::class, 'insert']);
    Route::post('directory/update', [DirectoryController::class, 'update']);
    Route::delete('directory/delete', [DirectoryController::class, 'delete']);

    # 上架管理
    Route::get('put-on', [PutOnController::class, 'index']);
    Route::get('put-on/count', [PutOnController::class, 'count']);
    Route::get('put-on/list/{page}', [PutOnController::class, 'list']);
    Route::post('put-on/insert', [PutOnController::class, 'insert']);
    Route::post('put-on/update', [PutOnController::class, 'update']);

    # 會員管理
    Route::get('member', [MemberController::class, 'index']);
});
