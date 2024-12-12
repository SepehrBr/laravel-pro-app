<?php

use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    $user = auth()->user();
    return view('admin.index', [
        'user' => $user
    ]);
})->name('index');
