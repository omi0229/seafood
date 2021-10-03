<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsTypeController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\DirectoryController;
use App\Http\Controllers\Api\PutOnController;

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

# 最新消息
Route::get('news-type/list/{page}', [NewsTypeController::class, 'list']);
Route::get('news/{type_id}/{page?}', [NewsController::class, 'list']);
Route::get('news-info/{id}', [NewsController::class, 'info']);

#線上購物
Route::get('directory/list/{page}', [DirectoryController::class, 'list']);
Route::get('product/{type_id}/{page?}', [PutOnController::class, 'list']);
