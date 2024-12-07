<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->middleware(['auth', 'verified']);

Auth::routes([
    'verify'=> true,
]);

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// password confirm and email confirm
Route::get('secret', function () {
    return 'secret';
})->middleware(['auth', 'password.confirm', 'verified']);

// profile
Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('profile/twofactor', [ProfileController::class, 'manageTwofactor'])->name('twofactor');
    Route::post('profile/twofactor', [ProfileController::class, 'postTwofactor']);

    Route::get('profile/twofactor/phone',[ProfileController::class,'getPhoneVerify'])->name('twofactor.phone');
    Route::post('profile/twofactor/phone', [ProfileController::class,'postPhoneVerify']);
});
