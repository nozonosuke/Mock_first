<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;

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
    Route::get('/mypage', [MypageController::class, 'index']);
    Route::get('/mypage/profile', [MypageController::class, 'editProfile']);
    Route::post('/mypage/profile', [MypageController::class, 'updateProfile']);
});

Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');

Route::post('/item/{item}/comment', [CommentController::class, 'store'])->middleware('auth')->name('comment.store');

Route::post('/item/{item}/favorite', [FavoriteController::class, 'toggle'])->middleware('auth')->name('item.favorite');