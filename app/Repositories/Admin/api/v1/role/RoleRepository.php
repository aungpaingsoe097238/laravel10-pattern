<?php

namespace App\Repositories\Admin\api\v1\role;

use Spatie\Permission\Models\Role;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    /**
     *  @param Role
     *  Create Permissions for Role
     */
    public function createRoleWithPermissions(array $data): Role
    {
        $role = Role::create([
            'name' => $data['name'],
        ]);
        $role->syncPermissions($data['permissions'] ?? []);
        return $role;
    }

    /**
     *  @param Role
     *  Upldate Permission for Role
     */
    public function updateRoleWithPermissions(Role $role, array $data): Role
    {
        $data['name'] = $data['name'] ?? $role->name;
        $role->update([
            'name' => $data['name'],
        ]);
        $role->syncPermissions($data['permissions']);
        return $role;
    }
}
