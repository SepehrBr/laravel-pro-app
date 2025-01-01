<?php

use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Permission;
use App\Models\User;

Route::get('/', function () {
    $user = auth()->user();
    return view('admin.index', [
        'user' => $user
    ]);
})->name('index');


// users
Route::resource('users', AdminUsersController::class);

// permission
Route::resource('permissions', PermissionController::class);

// role
// Route::resource('roles', RuleController::class);
