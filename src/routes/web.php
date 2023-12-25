<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;

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
Route::middleware('verified')->group(function () {
    Route::get('/index', [AuthController::class, 'list']);
});
Route::get('/', [ShopController::class, 'lists']);
Route::get('/thanks', [ShopController::class, 'thanks']);
Route::post('/favo_change', [ShopController::class, 'favo_change']);
Route::get('/search', [ShopController::class, 'search']);
Route::get('/detail/{shop_id}', [ShopController::class, 'detail'])->name('detail');
Route::post('/detail/{shop_id}', [ShopController::class, 'reserve'])->name('detail');
Route::get('/done', [ShopController::class, 'done']);
Route::get('/mypage', [ShopController::class, 'mypage']);
Route::get('/reserve_delete', [ShopController::class, 'reserve_delete']);
Route::post('/reserve_delete', [ShopController::class, 'reserve_delete']);
Route::post('/favo_change_mypage', [ShopController::class, 'favo_change_mypage']);
Route::get('/reserve_change', [ShopController::class, 'reserve_change']);
Route::post('/reserve_change', [ShopController::class, 'reserve_change']);
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/payment', [ShopController::class, 'payment'])->name('payment');
    Route::post('/payments', [ShopController::class, 'payments'])->name('payments');
});
Route::get('/manage', [ShopController::class, 'manage'])->middleware('manage.auth');
Route::post('/create', [ShopController::class, 'create'])->middleware('manage.auth');
Route::get('/owner', [ShopController::class, 'owner'])->middleware('owner.auth');
Route::get('/send_mail', [ShopController::class, 'send_mail'])->middleware('owner.auth');
Route::post('/send_mail', [ShopController::class, 'send_mail'])->middleware('owner.auth');
Route::get('/update', [ShopController::class, 'update'])->middleware('owner.auth');
Route::post('/update', [ShopController::class, 'update'])->middleware('owner.auth');
Route::get('/review', [ShopController::class, 'review']);
Route::post('/review', [ShopController::class, 'reviews']);
Route::get('/check/{reserve_id}', [ShopController::class, 'check'])->name('check');