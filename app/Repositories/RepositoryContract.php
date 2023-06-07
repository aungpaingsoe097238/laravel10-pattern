<?php

namespace App\Repositories;

interface RepositoryContract
{
    public function index();
    public function show();
    public function store(array $data);
    public function update(array $data);
    public function delete();
}
