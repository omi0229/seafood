<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\NewsTypeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CookingTypeController;
use App\Http\Controllers\CookingController;


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

    # 最新消息分類
    Route::get('cooking-type', [CookingTypeController::class, 'index']);
    Route::get('cooking-type/count', [CookingTypeController::class, 'count']);
    Route::get('cooking-type/list/{page}', [CookingTypeController::class, 'list']);
    Route::post('cooking-type/insert', [CookingTypeController::class, 'insert']);
    Route::post('cooking-type/update', [CookingTypeController::class, 'update']);
    Route::delete('cooking-type/delete', [CookingTypeController::class, 'delete']);

    # 最新消息
    Route::get('cooking', [CookingController::class, 'index']);
    Route::get('cooking/count', [CookingController::class, 'count']);
    Route::get('cooking/list/{page}', [CookingController::class, 'list']);
    Route::post('cooking/insert', [CookingController::class, 'insert']);
    Route::post('cooking/update', [CookingController::class, 'update']);
    Route::delete('cooking/delete', [CookingController::class, 'delete']);
});
