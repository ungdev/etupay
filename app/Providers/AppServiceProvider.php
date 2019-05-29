<?php

namespace App\Providers;

use App\Models\Service;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Service::creating(function (Service $service) {
            $service->generateApiKey();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (!App::environment('local')) {
            URL::forceScheme('https');
        }
    }

}
