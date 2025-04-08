<?php

declare(strict_types=1);

namespace Psprokofiev\LaravelRepository;

use Webmozart\Assert\Assert;

/**
 * Trait InteractsWithRepository
 */
trait InteractsWithRepository
{
    public static function repository(): Repository
    {
        $class = self::defineClass();

        Assert::classExists($class);

        return new $class(static::class);
    }

    private static function defineClass(): string
    {
        if (!empty(static::$repository)) {
            return static::$repository;
        }

        return \sprintf(
            'App\\Repositories\\%sRepository',
            basename(static::class),
        );
    }
}
