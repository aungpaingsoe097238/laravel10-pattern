<?php

namespace App\Http\Controllers\Mobile\api\v1\post;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\api\v1\post\PostResource;
use App\Repositories\Mobile\api\v1\post\PostRepository;
use App\Http\Resources\Mobile\api\v1\post\PostCollection;

class PostController extends Controller
{
    protected $postRepository;
    protected $with = [];

    function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
        $this->with = ['category'];
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
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = $this->postRepository->get($post);
        return new PostResource($post->load($this->with));
    }
}
