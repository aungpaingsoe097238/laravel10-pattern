<?php

namespace App\Http\Resources\Admin\api\v1\image;

use App\Utlis\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\api\v1\user\UserResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $routeName = Route::currentRouteName();
        if ($routeName === 'images.destroy') {
            return parent::toArray($request);
        }

        return [
            'id' => $this->id,
            'full_url' => $this->full_url,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
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
