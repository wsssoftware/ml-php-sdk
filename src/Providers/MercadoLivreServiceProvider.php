<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace MercadoLivre\Providers;

use Illuminate\Foundation\Application;
use MercadoLivre\Utility\Factory;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MercadoLivreServiceProvider extends PackageServiceProvider
{
    /**
     * @param  \Spatie\LaravelPackageTools\Package  $package
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('mercado-livre')
            ->hasConfigFile(['mercadolivre'])
            ->hasCommands([]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Factory::class, function (Application $app) {
            return new Factory();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->commands([]);
    }
}
