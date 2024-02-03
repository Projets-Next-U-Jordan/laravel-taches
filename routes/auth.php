<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('register', 'showRegister')->name('register');
    Route::post('register', 'handleRegister')->name('handleRegister');
    Route::get('login', 'showLogin')->name('login');
    Route::post('login', 'handleLogin')->name('handleLogin');
});