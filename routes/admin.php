<?php

use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
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
Route::get('users/{user}/permissions', [\App\Http\Controllers\Admin\User\PermissionController::class, 'create'])->name('users.permissions.create');
Route::post('users/{user}/permissions', [\App\Http\Controllers\Admin\User\PermissionController::class, 'store'])->name('users.permissions.store');

// permission
Route::resource('permissions', PermissionController::class);

// role
Route::resource('roles', RoleController::class);
