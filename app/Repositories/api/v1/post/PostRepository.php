<?php

namespace App\Repositories\api\v1\post;

use App\Http\Resources\api\v1\post\PostCollection;
use App\Http\Resources\api\v1\post\PostResource;
use App\Models\Post;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{

    protected $with;

    public function __construct()
    {
        $this->with = ['category'];
    }

    public function index()
    {
        $posts = Post::with($this->with)->filter(request()->all())->orderBy("id","desc");
        if(request()->has('paginate')){
            $posts = $posts->paginate(request()->get('paginate'));
        }else{
            $posts = $posts->get();
        }
        return new PostCollection($posts);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function store(array $data)
    {
        $post = Post::create([
            'title' => $data['title'],
            'category_id' => $data['category_id']
        ]);
        return new PostResource($post);
    }

    public function update(array $data, Post $post)
    {
        $data['title'] = isset($data['title']) ? $data['title'] : $post->title;
        $post->update([
            'title' => $data['title']
        ]);
        return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return BaseRepository::deleteSuccess('post id '.$post->id.' delete successfully');
    }
}
