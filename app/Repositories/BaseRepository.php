<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $model;
    protected $with = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function with($relations)
    {
        $this->with = $relations;
        return $this;
    }

    public function getAll()
    {
        $query = $this->model->with($this->with);

        if ($this->model->hasNamedScope('filter')) {
            $query->filter();
        }

        $results = $query->when(request()->has('paginate'), function ($query) {
            return $query->paginate(request()->get('paginate'));
        }, function ($query) {
            return $query->get();
        });

        return $results;
    }

    public function get(Model $model)
    {
        return $model;
    }

    public function create(array $data)
    {
        $model = $this->model->create($data);
        $model->load($this->with);
        return $model;
    }

    public function update(Model $model, array $data)
    {
        $model->update($data);
        return $model;
    }

    public function delete(Model $model)
    {
        $model->delete();
    }
}
