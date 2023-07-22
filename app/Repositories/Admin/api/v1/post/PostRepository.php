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

    /**
     *  Create New Post
     *  @param Post
     */
    public function createPost($data) : Post
    {
        // Upload new image to OSS cloud
        $image = $this->ossImageService->uploadImage($data['image']);
        // Create new image
        $imageData = Image::create($image + ['user_id' => Auth::user()->id]);
        // Create new post
        $post = Post::create($data + ['image_id' => $imageData->id]);
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
            // Delete old image from OSS cloud
            $this->ossImageService->deleteImage($post->image->full_url);
        }
        // Upload new image to OSS cloud
        $imageData = $this->ossImageService->uploadImage($data['image']);
        // Create or update the image associated with the post
        $image = $post->image()->updateOrCreate([], $imageData + ['user_id' => Auth::id()]);
        // Update image_id to the current post
        $post->update(['image_id' => $image->id]);
        // Return the updated post instance
        return $post;
    }
}
