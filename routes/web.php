<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
