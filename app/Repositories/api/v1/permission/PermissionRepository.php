<?php

namespace App\Repositories\api\v1\permission;

use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\api\v1\permission\PermissionResource;
use App\Http\Resources\api\v1\permission\PermissionCollection;

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

    public function getRolePermission($id)
    {
        return Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
    }

    public function getRolePermissions($id)
    {
        return DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
    }
}
