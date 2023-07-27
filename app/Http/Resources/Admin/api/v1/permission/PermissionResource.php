<?php

namespace App\Http\Resources\Admin\api\v1\permission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $routeName = Route::currentRouteName();
        if ($routeName === 'permissions.destroy') {
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
                'permissions.store' => 'Permission create successfully',
                'permissions.show' => 'Permission details retrieved successfully',
                'permissions.update' => 'Permission updated successfully',
                'permissions.destroy' => 'Permission deleted successfully',
                default => 'Unknown route',
            },
            'status' => in_array($routeName, ['permissions.store', 'permissions.show', 'permissions.update', 'permissions.destroy']),
        ];
    }
}
