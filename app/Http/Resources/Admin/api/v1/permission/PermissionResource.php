<?php

namespace App\Http\Resources\Admin\api\v1\permission;

use App\Utlis\Json;
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
        return Json::resource($request);
    }
}
