<?php

namespace Psprokofiev\LaravelRepository;

use Psprokofiev\LaravelRepository\Exceptions\RepositoryNotFound;

/**
 * Trait InteractsWithRepository
 * @package Psprokofiev\LaravelRepository
 */
trait InteractsWithRepository
{
    /**
     * @return Repository
     */
    public static function repository()
    {
        $class = self::defineClass();
        if (! class_exists($class)) {
            throw new RepositoryNotFound($class);
        }

        return new $class(static::class);
    }

    /**
     * @return string
     */
    private static function defineClass()
    {
        return sprintf(
            "App\\Repositories\\%sRepository",
            basename(static::class)
        );
    }
}
