<?php

namespace App\Providers;

use App\Services\OSSImageService;
use Illuminate\Support\ServiceProvider;

class OSSImageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind('ossImageService', function ($app) {
            return new OSSImageService();
        });
    }
}
