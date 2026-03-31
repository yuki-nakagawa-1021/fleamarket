<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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
Route::get('/search', [ItemController::class, 'search']);
Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item_id}', [ItemController::class, 'show']);
Route::post('/webhook/stripe', [PurchaseController::class, 'webhook']);

Route::middleware('auth')->group(function () {

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/mypage/profile');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');

    Route::middleware('verified')->group(function () {
        Route::get('/mypage', [MypageController::class, 'index']);
        Route::get('/mypage/profile', [ProfileController::class, 'edit']);
        Route::post('/mypage/profile', [ProfileController::class, 'update']);
        Route::get('/sell', [ItemController::class, 'create']);
        Route::post('/sell', [ItemController::class, 'store']);
        Route::get('/item/like/{item_id}', [LikeController::class, 'like']);
        Route::get('/item/unlike/{item_id}', [LikeController::class, 'unlike']);
        Route::post('/item/comments/{item_id}', [CommentController::class, 'store']);
        Route::get('/purchase/success', [PurchaseController::class, 'success']);
        Route::get('/purchase/{item_id}', [PurchaseController::class, 'create']);
        Route::post('/purchase/{item_id}', [PurchaseController::class, 'store']);
        Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress']);
        Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress']);
    });
});