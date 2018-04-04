<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class ExcelHelperProvider extends ServiceProvider
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
        App::bind('ExcelHelper', function()
        {
            return new App\Libraries\ExcelHelper;
        });
    }
}
