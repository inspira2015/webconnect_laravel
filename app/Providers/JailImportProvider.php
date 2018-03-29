<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class JailImportProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\JailImport::observe(\App\Observers\JailImportObserver::class);
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
