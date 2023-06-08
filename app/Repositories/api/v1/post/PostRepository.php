<?php

namespace App\Repositories\api\v1\post;

use App\Models\Post;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function index()
    {
        $posts = Post::all();
        return BaseRepository::json($posts);
    }
    public function show(Post $post)
    {
        return BaseRepository::json($post);
    }
    public function store(array $data)
    {
        $post = Post::create([
            'title' => $data['title']
        ]);
        return BaseRepository::json($post);
    }
    public function update(array $data, Post $post)
    {
        $data['title'] = isset($data['title']) ? $data['title'] : $post->title;
        $post->update([
            'title' => $data['title']
        ]);
        return BaseRepository::json($post);
    }
    public function destroy(Post $post)
    {
        return BaseRepository::json($post);
    }
}
