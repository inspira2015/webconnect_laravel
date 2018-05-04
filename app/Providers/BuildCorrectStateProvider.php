<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Services\BuildCorrectState;

class BuildCorrectStateProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Libraries\Services\BuildCorrectState', function ($app) {
          return new BuildCorrectState();
        });
    }
}
