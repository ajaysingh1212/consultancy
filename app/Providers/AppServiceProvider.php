<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 🔥 Super Admin & Admin → FULL ACCESS
        Gate::before(function ($user, $ability) {
            if (
                $user->hasRole('Super Admin') ||
                $user->hasRole('Admin')
            ) {
                return true;
            }
        });
    }
}
