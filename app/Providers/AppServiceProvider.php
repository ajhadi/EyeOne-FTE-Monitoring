<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS in production (fix mixed content)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            
            // Set APP_URL from environment
            $appUrl = env('APP_URL');
            if ($appUrl && str_starts_with($appUrl, 'https://')) {
                URL::forceRootUrl($appUrl);
            }
            
            // Trust proxies headers
            request()->server->set('HTTPS', 'on');
        }
    }
}
