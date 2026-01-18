<?php

namespace App\Providers;

use App\Label\EasyPost\Client;
use App\Label\Generator;
use Illuminate\Support\ServiceProvider;

class LabelServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Generator::class,
            function () {
                return new Client(
                    config('services.easypost.api_url'),
                    config('services.easypost.api_key'),
                    config('services.easypost.default_service'),
                    config('services.easypost.carrier_accounts'),
                );
            }
        );
    }
}
