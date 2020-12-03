<?php

namespace Psprokofiev\LaravelRepository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Psprokofiev\LaravelRepository\Exceptions\InvalidModel;
use Psprokofiev\LaravelRepository\Exceptions\UndefinedModel;
use Throwable;

/**
 * Class LaravelRepository
 * @package Psprokofiev\LaravelRepository
 */
abstract class LaravelRepository
{
    /** @var string */
    protected $model;

    /** @var Builder */
    protected $query;

    /**
     * BaseRepository constructor.
     *
     * @throws Throwable
     */
    public function __construct()
    {
        if (empty($this->model)) {
            throw new UndefinedModel();
        }

        if (get_parent_class($this->model) !== Model::class) {
            throw new InvalidModel();
        }

        $this->query = app($this->model)->newQuery();
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return app($this->model)->getTable();
    }
}
