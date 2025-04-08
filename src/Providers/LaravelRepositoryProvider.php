<?php

declare(strict_types=1);

namespace Psprokofiev\LaravelRepository\Providers;

use Illuminate\Support\ServiceProvider;
use Psprokofiev\LaravelRepository\Commands\RepositoryMakeCommand;

/**
 * Class LaravelRepositoryProvider
 */
final class LaravelRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindRepositories();
    }

    public function boot(): void
    {
        $this->commands(RepositoryMakeCommand::class);
    }

    public function bindRepositories(): void
    {
        $dir_name = base_path('app/Repositories');

        foreach (glob($dir_name.'/*Repository.php') as $filename) {
            $name = str_replace($dir_name.'/', '', $filename);
            $repository = 'App\\Repositories\\'.str_replace('.php', '', $name);

            $this->app->singleton($repository, static fn (): object => new $repository());
        }
    }
}
