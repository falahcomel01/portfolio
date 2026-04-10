<?php

namespace App\Providers;

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
    \Illuminate\Support\Facades\Redirect::macro('intended', function ($default = '/') {
        return app(\Illuminate\Routing\Redirector::class)->to($default);
    });
}
}
