<?php

namespace App\Providers;

use App\Currencies;
use App\CurrenciesCache;
use App\CurrencyGateway;
use App\ICurrencies;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(ICurrencies::class, function ($app) {
            return new CurrenciesCache(
                new Currencies(
                    new CurrencyGateway()
                )
            );
        });

        App::bind('SourceCurrencies', function () {
            return new CurrenciesCache(
                new Currencies(
                    new CurrencyGateway()
                )
            );
        });
    }
}
