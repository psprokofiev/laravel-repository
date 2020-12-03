<?php

namespace Psprokofiev\LaravelRepository\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MakeRepository
 * @package Psprokofiev\LaravelRepository\Commands
 */
class RepositoryMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name=DummyRepository} {--model=Dummy}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make new repository';

    /**
     * @var string
     */
    protected $type = 'Repository';

    /**
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a repository for the given model.'],
        ];
    }

    protected function getStub()
    {
        return __DIR__ . '/stubs/repository.stub';
    }

    /**
     * @param  string  $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repositories';
    }

    /**
     * @param  string  $name
     *
     * @return string
     * @throws FileNotFoundException
     */
    protected function buildClass($name)
    {
        $replace = $this->buildModelReplacements();

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * @return array
     */
    protected function buildModelReplacements()
    {
        $modelClass = $this->parseModel(
            $this->defineModel()
        );

        if (! class_exists($modelClass)) {
            if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $modelClass]);
            }
        }

        return [
            '{{ model }}' => class_basename($modelClass),
        ];
    }

    /**
     * @return string
     */
    protected function defineModel()
    {
        if (! empty($this->option('model'))) {
            return $this->option('model');
        }

        return Str::replaceLast('Repository', '', $this->argument('name'));
    }

    /**
     * @param  string  $model
     *
     * @return string
     * @throws InvalidArgumentException
     */
    protected function parseModel(string $model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        return $this->qualifyModel($model);
    }
}
