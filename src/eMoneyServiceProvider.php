<?php

namespace Gabievi\eMoney;

use Illuminate\Support\ServiceProvider;

class eMoneyServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('eMoney.php'),
        ]);
    }

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'eMoney');

        $this->app['eMoney'] = $this->app->share(function () {
            return new eMoney();
        });
    }
}
