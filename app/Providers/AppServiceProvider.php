<?php

namespace App\Providers;

use App\Models\Payment;
use App\Observers\PaymentObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Spatie\Permission\Middleware\PermissionMiddleware;
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
        Payment::observe(new PaymentObserver());
    }
}
