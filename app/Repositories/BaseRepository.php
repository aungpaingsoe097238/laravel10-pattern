<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        $results = $this->model;
        if ($this->model->hasNamedScope('filter')) {
            $results = $results->filter();
        }
        if (request()->has('paginate')) {
            $results = $results->paginate(request()->get('paginate'));
        } else {
            $results = $results->get();
        }
        return $results;
    }

    public function get(Model $model)
    {
        return $model;
    }

    public function create(array $data)
    {
        $model = $this->model->create($data);
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
