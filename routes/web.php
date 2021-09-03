<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index']);

Route::get('login', [\App\Http\Controllers\LoginController::class, 'login']);

Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

# 使用者管理
Route::get('user', [\App\Http\Controllers\UserController::class, 'index']);
Route::post('user/insert', [\App\Http\Controllers\UserController::class, 'insert']);
Route::post('user/update', [\App\Http\Controllers\UserController::class, 'update']);
