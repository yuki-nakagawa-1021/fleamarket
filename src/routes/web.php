<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;

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
Route::get('/', [ItemController::class, 'index']);
Route::get('/search', [SearchController::class, 'search']);
Route::get('/item/{item_id}', [ItemController::class, 'show']);

Route::middleware(['auth'])->group(function () {
    Route::get('/mypage', [MypageController::class, 'index']);
    Route::get('/mypage/profile', [ProfileController::class, 'edit']);
    Route::post('/mypage/profile', [ProfileController::class, 'update']);
    Route::get('/sell', [ItemController::class, 'create']);
    Route::post('/sell', [ItemController::class, 'store']);
    Route::post('/items/{item}/image', [ItemController::class, 'updateImage']);
    Route::get('/item/like/{item_id}', [LikeController::class, 'like']);
    Route::get('/item/unlike/{item_id}', [LikeController::class, 'unlike']);
    Route::post('/item/comments/{item_id}', [CommentController::class, 'store']);
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'create']);
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store']);
});