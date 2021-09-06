<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
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

    # 權限管理
    Route::get('role', [RoleController::class, 'index']);
    Route::get('role/count', [RoleController::class, 'count']);
    Route::get('role/list/{page}', [RoleController::class, 'list']);
    Route::post('role/insert', [RoleController::class, 'insert']);
    Route::post('role/update', [RoleController::class, 'update']);
    Route::delete('role/delete', [RoleController::class, 'delete']);

    # 使用者管理
    Route::get('user', [UserController::class, 'index']);
    Route::get('user/count', [UserController::class, 'count']);
    Route::get('user/list/{page}', [UserController::class, 'list']);
    Route::post('user/insert', [UserController::class, 'insert']);
    Route::post('user/update', [UserController::class, 'update']);
    Route::delete('user/delete', [UserController::class, 'delete']);
});
