<?php

namespace App\Http\Controllers\api\v1\category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\category\StoreCategoryRequest;
use App\Http\Requests\api\v1\category\UpdateCategoryRequest;
use App\Repositories\api\v1\category\CategoryRepository;

class CategoryController extends Controller
{

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->middleware('permission:category_list|category_create|category_edit|category_delete', ['except' => ['index','show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->categoryRepository->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        return $this->categoryRepository->store($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->categoryRepository->show($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        return $this->categoryRepository->update($request->all(),$category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        return $this->categoryRepository->destroy($category);
    }
}
