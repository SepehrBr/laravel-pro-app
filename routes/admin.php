<?php

use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\User;

Route::get('/', function () {
    $user = auth()->user();
    return view('admin.index', [
        'user' => $user
    ]);
})->name('index');


// users
Route::resource('users', AdminUsersController::class);
