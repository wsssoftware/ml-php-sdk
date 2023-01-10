<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace MercadoLivre;

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
            ->hasConfigFile(['mercadolivre']);
    }

    /**
     * Register services.
     *
     * @return void
     * @throws \Spatie\LaravelPackageTools\Exceptions\InvalidPackage
     */
    public function register(): void
    {
        parent::register();
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
        parent::boot();
        $this->commands([]);
    }
}
