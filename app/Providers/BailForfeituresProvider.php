<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BailForfeituresProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\BailForfeitures::observe(\App\Observers\BailForfeituresObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
