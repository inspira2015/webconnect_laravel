<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BailTransactionsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        \App\Models\BailTransactions::observe(\App\Observers\BailTransactionObserver::class);
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
