<?php

namespace Psprokofiev\LaravelRepository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Psprokofiev\LaravelRepository\Exceptions\InvalidEloquentModel;

/**
 * Class LaravelRepository
 * @package Psprokofiev\LaravelRepository
 */
abstract class Repository
{
    /** @var string */
    protected $model;

    /**
     * Repository constructor.
     *
     * @param  string  $model
     *
     * @throws InvalidEloquentModel
     */
    public function __construct(string $model)
    {
        $this->model = $model;

        if (! Arr::has(class_parents($this->model), Model::class)) {
            throw new InvalidEloquentModel;
        }
    }

    /**
     * @param  int|string  $id
     * @param  string  $key
     * @param  string|array  $columns
     *
     * @return Model
     * @throws ModelNotFoundException
     */
    public function getSingle($id, string $key = 'id', $columns = ['*'])
    {
        return $this->query()->where($key, $id)->firstOrFail($columns);
    }

    /**
     * @param  int|string  $id
     * @param  string  $key
     * @param  string|array  $columns
     *
     * @return Model|null
     */
    public function findSingle($id, string $key = 'id', $columns = ['*'])
    {
        return $this->query()->where($key, $id)->first($columns);
    }

    /**
     * @return Builder|Model|mixed
     */
    public function query()
    {
        return $this->model::query();
    }
}
