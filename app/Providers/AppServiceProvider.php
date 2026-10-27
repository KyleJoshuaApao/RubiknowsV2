<?php

namespace App\Providers;

use App\View\Composers\AdminNotificationComposer;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('layouts.app', AdminNotificationComposer::class);

        // Models bind by numeric id; Postgres throws on non-numeric ids, so
        // reject them at the router and return a 404 instead of a 500.
        Route::patterns(array_fill_keys([
            'service', 'project', 'gallery', 'testimonial', 'client', 'user',
            'job', 'application', 'message', 'quotation',
        ], '[0-9]+'));
    }
}
