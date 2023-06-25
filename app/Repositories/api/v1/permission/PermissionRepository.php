<?php

namespace App\Repositories\api\v1\permission;

use App\Http\Resources\api\v1\permission\PermissionCollection;
use App\Http\Resources\api\v1\permission\PermissionResource;
use App\Repositories\BaseRepository;
use Spatie\Permission\Models\Permission;

class PermissionRepository
{
    public function index()
    {
        $permissions = Permission::all();
        return new PermissionCollection($permissions);
    }

    public function show(Permission $permission)
    {
        return new PermissionResource($permission);
    }

    public function store(array $data)
    {
        $permission = Permission::create([
            'name' => $data['name'],
            'guard_name' => 'api'
        ]);
        return new PermissionResource($permission);
    }

    public function update(array $data, Permission $permission)
    {
        $data['name'] = isset($data['name']) ? $data['name'] : $permission->name;
        $permission->update([
            'name' => $data['name']
        ]);
        return new PermissionResource($permission);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return BaseRepository::deleteSuccess('permission id ' . $permission->id . ' delete successfully');
    }
}
