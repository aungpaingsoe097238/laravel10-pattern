<?php

namespace App\Repositories\Admin\api\v1\post;

use App\Models\Post;
use App\Models\Image;
use App\Repositories\BaseRepository;
use App\Services\ImageService\LocalImageService;
use Auth;

class PostRepository extends BaseRepository
{
    protected $localImageService;

    public function __construct(Post $post, LocalImageService $localImageService)
    {
        $this->localImageService = $localImageService;
        parent::__construct($post);
    }

    /**
     *  Create New Post
     *  @param Post
     */
    public function createPost($data) : Post
    {
        // Upload new image
        $image = $this->localImageService->uploadImage($data['image']);
        // Create new post
        $post = Post::create($data);
        $post->images()->create($image + ['user_id' => Auth::user()->id]);
        return $post;
    }

    /**
     *  Post Image Update
     *  @param Post
     */
    public function updateImage($id, $data): Post
    {
        $post = Post::findOrFail($id);
        // Check if the post has an existing image
        if ($post->image) {
            // Delete old image
            $this->localImageService->deleteImage($post->image->full_url);
        }
        // Upload new image
        $imageData = $this->localImageService->uploadImage($data['image']);
        // Create or update the image associated with the post
        $post->images()->updateOrCreate([], $imageData + ['user_id' => Auth::id()]);
        return $post;
    }
}
