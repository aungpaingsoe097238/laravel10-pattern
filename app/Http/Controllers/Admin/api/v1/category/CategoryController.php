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
        $this->middleware('permission:category-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:category-create', ['only' => ['store']]);
        $this->middleware('permission:category-edit', ['only' => ['update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): CategoryCollection
    {
        $categories = $this->categoryRepository->getAll();
        return new CategoryCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        $category = $this->categoryRepository->create($request->validated());
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): CategoryResource
    {
        $category = $this->categoryRepository->get($category);
        return new CategoryResource($category->load('posts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource
    {
        $category = $this->categoryRepository->update($category, $request->validated());
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): CategoryResource
    {
        $category = $this->categoryRepository->delete($category);
        return new CategoryResource($category);
    }
}
