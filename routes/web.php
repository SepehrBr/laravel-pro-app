<?php

use App\Http\Controllers\Auth\AuthTokenController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// for easy login
Route::get('/p', function () {
    auth()->loginUsingId(2);
    return redirect('/admin');
});
Route::get('/s', function () {
    auth()->loginUsingId(1);
    return redirect('/admin');
});

Route::get('/', function () {
    return view('home');
})->middleware(['auth', 'verified']);

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

// auth
Auth::routes([
    'verify'=> true,
]);
// google loggin
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// token loggin
Route::get('auth/token', [AuthTokenController::class, 'getToken'])->name('twofactor.token');
Route::post('auth/token', [AuthTokenController::class, 'postToken']);
