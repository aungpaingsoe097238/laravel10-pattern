<?php

namespace App\Http\Controllers\Admin\api\v1\category;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\api\v1\category\CategoryResource;
use App\Repositories\Admin\api\v1\category\CategoryRepository;
use App\Http\Resources\Admin\api\v1\category\CategoryCollection;
use App\Http\Requests\Admin\api\v1\category\StoreCategoryRequest;
use App\Http\Requests\Admin\api\v1\category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryRepository->getAll();
        return new CategoryCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryRepository->create($request->validated());
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = $this->categoryRepository->get($category);
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category = $this->categoryRepository->update($category, $request->validated());
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category = $this->categoryRepository->delete($category);
        return new CategoryResource($category);
    }
}
