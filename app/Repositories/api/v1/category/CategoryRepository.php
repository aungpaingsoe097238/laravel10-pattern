<?php

namespace App\Repositories\api\v1\category;

use App\Http\Resources\api\v1\category\CategoryCollection;
use App\Http\Resources\api\v1\category\CategoryResource;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function index()
    {
        $categories = Category::all();
        return new CategoryCollection($categories);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function store(array $data)
    {
        $category = Category::create([
            'name' => $data['name']
        ]);
        return new CategoryResource($category);
    }

    public function update(array $data,Category $category)
    {
        $data['name'] = isset($data['name']) ? $data['name'] : $category->name;
        $category->update([
            'name' => $data['name']
        ]);
        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return new CategoryResource($category);
    }
}
