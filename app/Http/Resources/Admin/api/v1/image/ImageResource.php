<?php

namespace App\Http\Resources\Admin\api\v1\image;

use App\Http\Resources\Admin\api\v1\user\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Resources\Json\JsonResource;

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
        $routeName = Route::currentRouteName();
        return [
            'message' => match ($routeName) {
                'images.store' => 'Image create successfully',
                'images.show' => 'Image details retrieved successfully',
                'images.update' => 'Image updated successfully',
                'images.destroy' => 'Image deleted successfully',
                default => 'Unknown route',
            },
            'status' => in_array($routeName, ['images.store', 'images.show', 'images.update', 'images.destroy']),
        ];
    }
}
