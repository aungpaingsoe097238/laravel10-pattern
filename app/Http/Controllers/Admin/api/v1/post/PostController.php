<?php

namespace App\Http\Controllers\Admin\api\v1\post;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\api\v1\post\PostResource;
use App\Repositories\Admin\api\v1\post\PostRepository;
use App\Http\Resources\Admin\api\v1\post\PostCollection;
use App\Http\Requests\Admin\api\v1\post\StorePostRequest;
use App\Http\Requests\Admin\api\v1\post\UpdatePostRequest;
use App\Http\Requests\Admin\api\v1\post\UpdateImageRequest;

class PostController extends Controller
{
    protected $postRepository;
    protected $with = [];

    function __construct(PostRepository $postRepository)
    {
        $this->with = ['category', 'image'];
        $this->postRepository = $postRepository;
        $this->middleware('permission:post-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:post-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): PostCollection
    {
        $posts = $this->postRepository->getAll();
        return new PostCollection($posts->load($this->with));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): PostResource
    {
        $post = $this->postRepository->createPost($request->validated());
        return new PostResource($post->load($this->with));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): PostResource
    {
        $post = $this->postRepository->get($post);
        return new PostResource($post->load($this->with));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $post = $this->postRepository->update($post, $request->validated());
        return new PostResource($post->load($this->with));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): PostResource
    {
        $post = $this->postRepository->delete($post);
        return new PostResource($post);
    }

    /**
     * Update Image
     */
    public function updateImage(UpdateImageRequest $request, $id) : PostResource
    {
        $post = $this->postRepository->updateImage($id, $request->validated());
        return new PostResource($post->load($this->with));
    }
}
