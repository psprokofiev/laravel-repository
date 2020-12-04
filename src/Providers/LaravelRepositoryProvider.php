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
        $this->bindRepositories();
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

    /**
     * @return void
     */
    public function bindRepositories()
    {
        $repositories = [];
        $dir_name = base_path('app/Repositories');

        foreach (glob($dir_name . '/*Repository.php') as $filename) {
            $name = str_replace($dir_name . '/', '', $filename);
            $repositories[] = 'App\\Repositories\\' . str_replace('.php', '', $name);
        }

        foreach ($repositories as $repository) {
            $this->app->singleton($repository, function ($app) use ($repository) {
                return new $repository();
            });
        }
    }
}
