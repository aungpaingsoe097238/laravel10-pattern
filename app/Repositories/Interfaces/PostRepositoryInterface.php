<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;
use PHPUnit\Framework\Test;

interface PostRepositoryInterface
{
    public function index();
    public function show(Post $post);
    public function store(array $data);
    public function update(array $data,Post $post);
    public function destroy(Post $post);
}
