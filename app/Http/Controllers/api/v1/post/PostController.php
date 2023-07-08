<?php

namespace App\Http\Controllers\api\v1\post;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\post\StorePostRequest;
use App\Http\Requests\api\v1\post\UpdatePostRequest;
use App\Http\Resources\api\v1\post\PostCollection;
use App\Http\Resources\api\v1\post\PostResource;
use App\Repositories\api\v1\post\PostRepository;

class PostController extends Controller
{
    protected $postRepository;

    function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->postRepository->getAll();
        return new PostCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = $this->postRepository->create($request->validated());
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = $this->postRepository->get($post);
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post = $this->postRepository->update($post, $request->validated());
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post = $this->postRepository->delete($post);
        return new PostResource($post);
    }
}
