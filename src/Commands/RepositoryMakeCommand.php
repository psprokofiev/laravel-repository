<?php

declare(strict_types=1);

namespace Psprokofiev\LaravelRepository\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MakeRepository
 */
final class RepositoryMakeCommand extends GeneratorCommand
{
    protected $signature = 'make:repository {model}';

    protected $description = 'Make new repository';

    protected $type = 'Repository';

    protected function getArguments(): array
    {
        return [];
    }

    protected function getStub(): string
    {
        return __DIR__.'/stubs/repository.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "{$rootNamespace}\\Repositories";
    }

    /**
     * @param mixed $name
     *
     * @throws FileNotFoundException
     */
    protected function buildClass($name): string
    {
        $replace = $this->buildModelReplacements();

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name),
        );
    }

    protected function getNameInput(): string
    {
        return \sprintf('%sRepository', trim($this->argument('model')));
    }

    protected function getOptions(): array
    {
        return [
            ['model', null, InputOption::VALUE_REQUIRED, 'Model name'],
        ];
    }

    private function buildModelReplacements(): array
    {
        $modelClass = $this->defineModel();

        if (!class_exists($modelClass) && $this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
            $this->call('make:model', ['name' => $modelClass]);
        }

        return [
            '{{ model }}' => class_basename($modelClass),
        ];
    }

    private function defineModel(): string
    {
        return $this->qualifyModel(
            $this->argument('model'),
        );
    }
}
