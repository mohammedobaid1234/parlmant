<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Environment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('production')) {
            $this->app->bind('path.public', function($app) {
                return base_path('public_html');
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        // if (env('APP_ENV') !== 'local') {
        //     $url->forceSchema('https');
        // }
        // if (config('app.env') === 'production') {
        //     \URL::forceScheme('https');
        // }
    }
}