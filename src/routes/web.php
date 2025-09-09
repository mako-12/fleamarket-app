<?php

use App\Models\ItemCondition;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [ItemController::class, 'index'])->name('home');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');


Route::middleware('auth')->group(function () {
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->name('purchase');
    Route::post('/purchase/{item_id}', [ItemController::class, 'purchaseStore'])->name('purchase.store');
    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
    Route::post('/item', [ItemController::class, 'store'])->name('item.store');



    Route::get('/mypage', [ProfileController::class, 'index'])->name('mypage');
    Route::get('/purchase/address/{item_id}', [ProfileController::class, 'editAddress'])->name('editAddress');
    Route::post('/purchase/address/{item_id}', [ProfileController::class, 'updateAddress'])->name('updateAddress');
    Route::get('/mypage/profile', [ProfileController::class, 'setup'])->name('profile.setup');
    Route::post('/mypage/profile', [ProfileController::class, 'profileCreate'])->name('profile.create');
    Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])->name('comment.store');

    Route::post('/favorite/{item_id}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
});

Route::post('/favorites/{item}', [FavoriteController::class, 'toggle'])->name('favorites.toggle')->middleware('auth');

Route::post('/stripe/webhook',[\App\Http\Controllers\StripeWebhookController::class,'handle']);
