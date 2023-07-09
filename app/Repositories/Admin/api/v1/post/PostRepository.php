<?php

namespace App\Repositories\Admin\api\v1\post;

use App\Models\Post;
use App\Repositories\BaseRepository;

class PostRepository extends BaseRepository
{
    public function __construct(Post $post)
    {
        parent::__construct($post);
        $this->with = ['category']; // Set the desired relationships here
    }
}
