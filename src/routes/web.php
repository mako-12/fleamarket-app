<?php

use Illuminate\Http\Request;
use App\Models\ItemCondition;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\VerificationController;

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
Route::get('/search', [ItemController::class, 'search'])->name('search');

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


    Route::get('/checkout/success/{item_id}', [ItemController::class, 'success'])->name('checkout.success');

    Route::get('/checkout/cancel', [ItemController::class, 'index'])->name('checkout.cancel');

    //Proテスト追記部分
    Route::get('/transactions/{transaction}/chat', [ChatMessageController::class, 'index'])->name('chat.index');
    Route::post('/transactions/{transaction}/chat', [ChatMessageController::class, 'store'])->name('chat.store');
    Route::get('/transaction/{transaction}/chat/modal',[ChatMessageController::class,'modal'])->name('chat.modal');

    Route::get('/transaction/{transaction}/evaluation', [EvaluationController::class, 'create'])->name('evaluation.create');
    Route::post('/transaction/{transaction}/evaluation', [EvaluationController::class, 'store'])->name('evaluation.store');
});

Route::post('/favorites/{item}', [FavoriteController::class, 'toggle'])->name('favorites.toggle')->middleware('auth');



// //メール認証機能(未承認ユーザーをverifyにリダイレクト)
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

//認証リンククリック時
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])->name('verification.verify');

//再送ボタン
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', '認証メールを再送しました！');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//承認済ユーザーだけがアクセスできるように
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified']);

//承認リンクをクリックしたら承認されるように
Route::get('/email/check', function () {
    return redirect()->away('http://localhost:8025/#');
})->middleware('auth')->name('verification.check');



//メール認証テスト
Route::get('/test-mail', function () {
    Mail::raw('これはテストメールです！', function ($message) {
        $message->to('test@example.com')->subject('テスト送信');
    });

    return 'メールを送信しました！';
});
