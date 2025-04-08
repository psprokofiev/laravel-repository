<?php

declare(strict_types=1);

namespace Psprokofiev\LaravelRepository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Webmozart\Assert\Assert;

/**
 * Class LaravelRepository
 */
abstract class Repository
{
    /**
     * @param class-string<Model> $model
     */
    public function __construct(protected string $model)
    {
        Assert::inArray(Model::class, class_parents($this->model));
    }

    /**
     * @param int|string $id
     * @param list<string>|string $columns
     *
     * @throws ModelNotFoundException
     */
    public function getSingle(mixed $id, string $key = 'id', array|string $columns = ['*']): Model
    {
        return $this->query()->where($key, $id)->firstOrFail($columns);
    }

    /**
     * @param int|string $id
     * @param list<string>|string $columns
     */
    public function findSingle(mixed $id, string $key = 'id', array|string $columns = ['*']): ?Model
    {
        return $this->query()->where($key, $id)->first($columns);
    }

    public function query(): Builder|Model
    {
        return $this->model::query();
    }
}
