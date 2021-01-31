<?php

namespace Psprokofiev\LaravelRepository\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
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
    protected $signature = 'make:repository {model}';

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
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('model')) . 'Repository';
    }

    /**
     * @return array
     */
    protected function buildModelReplacements()
    {
        $modelClass = $this->defineModel();

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
        return $this->qualifyModel(
            $this->argument('model')
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', null, InputOption::VALUE_REQUIRED, 'Model name'],
        ];
    }
}
