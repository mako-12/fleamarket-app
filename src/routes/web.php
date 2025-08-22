<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Models\ItemCondition;
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

Route::get('/', [ItemController::class, 'index'])->name('home');
Route::get('/item/{item_id}', [ItemController::class, 'show']);


Route::middleware('auth')->group(function () {
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->name('purchase');
    Route::get('/sell', [ItemController::class, 'create']);
    Route::get('/mypage', [ProfileController::class, 'index']);
    Route::get('/purchase/address/{item_id}', [ProfileController::class, 'editAddress'])->name('editAddress');
    Route::post('/purchase/address/{item_id}', [ProfileController::class, 'updateAddress'])->name('updateAddress');
});

// 商品購入確定へのページ×
// Route::post('/purchase/{item_id}',[ItemController::class,'storeOder']);
