<?php

namespace App\Http\Controllers\api\v1\post;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {
        return $this->postRepository->store($request->all());
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
    public function update(Request $request, Post $post)
    {
        return $this->postRepository->update($request->all(),$post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        return $this->postRepository->destroy($post);
    }
}
