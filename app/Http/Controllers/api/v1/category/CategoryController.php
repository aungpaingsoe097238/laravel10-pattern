<?php

namespace App\Http\Controllers\api\v1\category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\api\v1\category\CategoryRepository;

class CategoryController extends Controller
{

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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
    public function store(Request $request)
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
    public function update(Request $request, Category $category)
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
