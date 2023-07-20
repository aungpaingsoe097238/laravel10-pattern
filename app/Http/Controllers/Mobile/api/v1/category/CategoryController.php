<?php

namespace App\Http\Controllers\Mobile\api\v1\category;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\api\v1\category\CategoryResource;
use App\Repositories\Mobile\api\v1\category\CategoryRepository;
use App\Http\Resources\Mobile\api\v1\category\CategoryCollection;

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
    public function index() : CategoryCollection
    {
        $categories = $this->categoryRepository->getAll();
        return new CategoryCollection($categories);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category) : CategoryResource
    {
        $category = $this->categoryRepository->get($category);
        return new CategoryResource($category->load('posts'));
    }

}
