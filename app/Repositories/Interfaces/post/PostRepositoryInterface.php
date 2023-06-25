<?php

namespace App\Repositories\Interfaces\post;

use App\Models\Post;

interface PostRepositoryInterface
{
    public function index();
    public function show(Post $post);
    public function store(array $data);
    public function update(array $data,Post $post);
    public function destroy(Post $post);
}
