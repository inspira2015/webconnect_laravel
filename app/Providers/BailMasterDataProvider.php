<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class BailMasterDataProvider extends ServiceProvider
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
        App::bind('BailMasterData', function()
        {
            return new App\Libraries\BailMasterData;
        });
    }
}
