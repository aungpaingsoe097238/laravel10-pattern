<?php

namespace App\Http\Controllers\api\v1\post;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\post\StorePostRequest;
use App\Http\Requests\api\v1\post\UpdatePostRequest;
use App\Repositories\api\v1\post\PostRepository;

class PostController extends Controller
{

    protected $postRepository;

    function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->postRepository->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        return $this->postRepository->store($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $this->postRepository->show($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        return $this->postRepository->update($request->validated(),$post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        return $this->postRepository->destroy($post);
    }
}
