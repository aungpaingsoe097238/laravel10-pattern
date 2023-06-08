<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;
use PHPUnit\Framework\Test;

interface PostRepositoryInterface
{
    public function index();
    public function show(Post $post);
    public function store(array $array);
    public function update(array $array,Post $post);
    public function destroy(Post $post);
}
