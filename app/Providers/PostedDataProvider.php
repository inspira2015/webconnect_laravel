<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class PostedDataProvider extends ServiceProvider
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
        App::bind('PostedData', function()
        {
            return new App\Libraries\PostedData;
        });
    }
}
