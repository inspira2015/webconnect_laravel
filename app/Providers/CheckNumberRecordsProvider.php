<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class CheckNumberRecordsProvider extends ServiceProvider
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
        App::bind('CheckNumberRecords', function()
        {
            return new App\Libraries\CheckNumberRecords;
        });
    }
}
