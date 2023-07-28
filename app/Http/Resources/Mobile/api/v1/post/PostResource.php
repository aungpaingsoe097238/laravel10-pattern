<?php

namespace App\Http\Resources\Mobile\api\v1\post;

use App\Utlis\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\api\v1\image\ImageResource;
use App\Http\Resources\Mobile\api\v1\category\CategoryResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $routeName = Route::currentRouteName();
        if ($routeName === 'posts.destroy') {
            return parent::toArray($request);
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'category_id' => $this->category->id,
            'description' => $this->when(!$request->routeIs('posts.index'), fn () => $this->description), // show only in posts.index
            'image' => new ImageResource($this->whenLoaded('image')),
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return Json::resource($request);
    }
}
