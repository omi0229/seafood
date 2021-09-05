<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

    # 使用者管理
    Route::get('user', [UserController::class, 'index']);
    Route::get('user/list/{page}', [UserController::class, 'list']);
    Route::post('user/insert', [UserController::class, 'insert']);
    Route::post('user/update', [UserController::class, 'update']);
    Route::delete('user/delete', [UserController::class, 'delete']);
});
