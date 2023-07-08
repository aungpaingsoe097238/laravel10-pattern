<?php

namespace App\Http\Resources\api\v1\category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $routeName = Route::currentRouteName();
        if ($routeName === 'categories.destroy') {
            return parent::toArray($request);
        }

        return [
            'id' => $this->id,
            'name' => $this->name
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
                'categories.store' => 'Category create successfully',
                'categories.show' => 'Category details retrieved successfully',
                'categories.update' => 'Category updated successfully',
                'categories.destroy' => 'Category deleted successfully',
                default => 'Unknown route',
            },
            'status' => in_array($routeName, ['categories.store', 'categories.show', 'categories.update', 'categories.destroy']),
        ];
    }
}
