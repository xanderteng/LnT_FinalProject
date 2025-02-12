<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmailController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'getLogin')->name('getLogin');
    Route::post('/login', 'login')->name('login');
    Route::get('/register', 'getRegister')->name('getRegister');
    Route::post('/register', 'register')->name('register');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/product', 'index')->name('product');
    Route::get('/cart', 'cart')->name('cart');
    Route::post('/add-to-cart', 'addToCart')->name('addToCart');
    Route::post('/update-address', 'updateAddress')->name('cart.updateAddress');
    Route::post('/update-cart', 'updateCart')->name('updateCart');
    Route::post('/remove-from-cart', 'removeFromCart')->name('removeFromCart');
    Route::post('/confirm-order', 'confirmOrder')->name('confirmOrder');
});

Route::get('/invoice/{id}', function ($id) {
    $invoice = DB::table('invoices')->where('id', $id)->first();
    if (!$invoice) {
        abort(404);
    }
    return view('invoice', compact('invoice'));
})->name('invoice.show');

Route::post('/send-email', [EmailController::class, 'sendEmail'])->name('sendEmail');