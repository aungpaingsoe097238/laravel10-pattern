<?php

namespace App\Http\Resources\api\v1\role;

use App\Http\Resources\api\v1\permission\PermissionCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'permissions' => new PermissionCollection($this->permissions),
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
        return [
            'message' => 'successfully',
            'status' => true,
        ];
    }
}
