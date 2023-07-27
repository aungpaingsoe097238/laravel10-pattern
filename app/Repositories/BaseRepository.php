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

    /**
     * Display a listing of the resource.
     */
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

    /**
     * Display the specified resource.
     */
    public function get(Model $model): Model
    {
        return $model;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(array $data): Model
    {
        $model = $this->model->create($data);
        return $model;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Model $model, array $data): Model
    {
        $model->update($data);
        return $model;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Model $model): void
    {
        $model->delete();
    }
}
