<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function index();
    public function show(Category $category);
    public function store(array $array);
    public function update(array $array,Category $category);
    public function destroy(Category $category);
}
