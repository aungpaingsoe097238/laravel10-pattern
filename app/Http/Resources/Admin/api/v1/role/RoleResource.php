<?php

namespace App\Http\Resources\Admin\api\v1\role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\api\v1\permission\PermissionCollection;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $routeName = Route::currentRouteName();
        if ($routeName === 'roles.destroy') {
            return parent::toArray($request);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'permissions' => new PermissionCollection($this->whenLoaded('permissions'))
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
                'roles.store' => 'Role create successfully',
                'roles.show' => 'Role details retrieved successfully',
                'roles.update' => 'Role updated successfully',
                'roles.destroy' => 'Role deleted successfully',
                default => 'Unknown route',
            },
            'status' => in_array($routeName, ['roles.store', 'roles.show', 'roles.update', 'roles.destroy']),
        ];
    }
}
