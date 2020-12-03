<?php

namespace Psprokofiev\LaravelRepository\Providers;

use Illuminate\Support\ServiceProvider;
use Psprokofiev\LaravelRepository\Commands\RepositoryMakeCommand;

/**
 * Class LaravelRepositoryProvider
 * @package Psprokofiev\LaravelRepository
 */
class LaravelRepositoryProvider extends ServiceProvider
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
        $this->commands(RepositoryMakeCommand::class);
    }
}
