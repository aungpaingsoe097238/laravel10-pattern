<?php

namespace App\Http\Resources\Admin\api\v1\auth;

use App\Utlis\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\api\v1\role\RoleCollection;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->routeIs('auth.logout')) {
            return [];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'token' => $this->when($request->routeIs('auth.login'), fn () => $this->token),
            'roles' => new RoleCollection($this->whenLoaded('roles', $this->roles)),
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
                'auth.login' => 'Login successfully.',
                'auth.register' => 'Registation successfully.',
                'auth.logout' => 'Logout successfully.',
                'auth.change_password' => 'Change password successfully.',
                default => 'Unknown route',
            },
            'status' => in_array($routeName, ['auth.login', 'auth.register', 'auth.logout', 'auth.change_password']),
        ];
    }
}
