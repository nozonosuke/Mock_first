<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
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

Route::get('/mypage/profile', function() {
    return view('mypage.profile');
})->middleware(['auth']);

Route::get('/', function () {
    return view('products.index');
})->middleware(['auth']);

Route::get('/', [ItemController::class, 'index'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [MypageController::class, 'index'])
        ->name('mypage.index');

    Route::get('/mypage/profile', [MypageController::class, 'editProfile'])
        ->name('mypage.profile');

    Route::post('/mypage/profile', [MypageController::class, 'updateProfile'])
        ->name('mypage.profile.update');

    Route::get('/purchase/{item}', [PurchaseController::class, 'show'])->name('purchase.purchase');

    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])
        ->name('purchase.address.edit');

    Route::post('purchase/address/{item}', [PurchaseController::class, 'updateAddress'])
        ->name('purchase.address.update');
});

Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');

Route::post('/item/{item}/comment', [CommentController::class, 'store'])->middleware('auth')->name('comment.store');

Route::post('/item/{item}/favorite', [FavoriteController::class, 'toggle'])->middleware('auth')->name('item.favorite');

