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
        // Fix for Cloudflare Tunnel Signatures (403 Errors)
        if (str_contains(request()->header('host'), 'trycloudflare.com') || request()->header('X-Forwarded-Proto') === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
            // Dynamically update APP_URL for signatures
            config(['app.url' => request()->getSchemeAndHttpHost()]);
        }

        // Only apply strict password rules in production/local, not during tests
        if (!app()->runningUnitTests()) {
            \Illuminate\Validation\Rules\Password::defaults(function () {
                return \Illuminate\Validation\Rules\Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised();
            });
        }
    }
}
