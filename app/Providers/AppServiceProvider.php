<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('edit-user', function ($user, $current_user) {
            // dd ($user->name);
            if ($user->is_admin) {
                return true;
            }

            return $current_user->id == $user->id;
        });
    }
}
