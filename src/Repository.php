<?php

namespace Psprokofiev\LaravelRepository;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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

    /** @var Builder */
    protected $query;

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

        $this->query = app($this->model);
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->query->getTable();
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->query->getConnection();
    }

    /**
     * @param  int  $id
     *
     * @return Model|null
     */
    public function getSingle(int $id)
    {
        return $this->query->find($id);
    }

    /**
     * @return Builder|Model|mixed
     */
    public function getQuery()
    {
        return $this->query;
    }
}
