<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function getAll();

    public function get(Model $model);

    public function create(array $data);

    public function update(Model $model, array $data);

    public function delete(Model $model);
}
