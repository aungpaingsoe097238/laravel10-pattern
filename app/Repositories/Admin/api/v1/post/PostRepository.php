<?php

namespace App\Repositories\Admin\api\v1\post;

use App\Models\Post;
use App\Models\Image;
use App\Services\OSSImageService;
use App\Repositories\BaseRepository;
use Auth;

class PostRepository extends BaseRepository
{
    protected $ossImageService;

    public function __construct(Post $post, OSSImageService $ossImageService)
    {
        $this->ossImageService = $ossImageService;
        parent::__construct($post);
    }

    public function createPost($data)
    {
        $post = Post::create($data);
        $response = $this->ossImageService->uploadImageBase64($data['image']);
        if ($response) {
            $image = new Image($response + ['user_id' => Auth::user()->id]);
            $post->image()->save($image);
        }
        return $post;
    }
}
