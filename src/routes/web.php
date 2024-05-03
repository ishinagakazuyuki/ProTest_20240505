<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ManageController;

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

Auth::routes(['verify' => true]);
Route::get('/', [AuthController::class, 'index']);
Route::get('/thanks', [AuthController::class, 'thanks']);

Route::get('/search', [ShopController::class, 'search']);
Route::get('/detail/{shop_id}', [ShopController::class, 'detail'])->name('detail');
Route::get('/done', [ShopController::class, 'done']);
Route::get('/mypage', [ShopController::class, 'mypage']);

Route::post('/favo_change', [FavoriteController::class, 'favo_change']);
Route::post('/favo_change_mypage', [FavoriteController::class, 'favo_change_mypage']);

Route::post('/detail/{shop_id}', [ReserveController::class, 'reserve'])->name('detail');
Route::get('/reserve_delete', [ReserveController::class, 'reserve_delete']);
Route::post('/reserve_delete', [ReserveController::class, 'reserve_delete']);
Route::get('/reserve_change', [ReserveController::class, 'reserve_change']);
Route::post('/reserve_change', [ReserveController::class, 'reserve_change']);

Route::get('/review/{shop_id}', [ReviewController::class, 'review'])->name('review');
Route::post('/review/{shop_id}', [ReviewController::class, 'reviews']);

Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/payment', [PaymentController::class, 'payment'])->name('payment');
    Route::post('/payments', [PaymentController::class, 'payments'])->name('payments');
});

Route::get('/manage', [ManageController::class, 'manage'])->middleware('manage.auth');
Route::post('/create', [ManageController::class, 'create'])->middleware('manage.auth');
Route::get('/owner', [ManageController::class, 'owner'])->middleware('owner.auth');
Route::get('/send_mail', [ManageController::class, 'send_mail'])->middleware('owner.auth');
Route::post('/send_mail', [ManageController::class, 'send_mail'])->middleware('owner.auth');
Route::get('/update', [ManageController::class, 'update'])->middleware('owner.auth');
Route::post('/update', [ManageController::class, 'update'])->middleware('owner.auth');
Route::get('/check/{reserve_id}', [ManageController::class, 'check'])->name('check');