<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OtpController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/verify-otp', [OtpController::class, 'verifyOtpForm'])->name('send.otp');
    Route::post('/verify-otp-action', [OtpController::class, 'verifyOtp'])->name('verify.otp');

    Route::middleware(['otp.verified'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    });
});

Auth::routes();

