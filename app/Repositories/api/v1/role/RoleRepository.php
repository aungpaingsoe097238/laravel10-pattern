<?php

namespace App\Repositories\api\v1\role;

use Spatie\Permission\Models\Role;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    public function createRoleWithPermissions(array $data)
    {
        $role = Role::create([
            'name' => $data['name'],
        ]);

        $role->syncPermissions($data['permissions'] ?? []);

        return $role;
    }

    public function updateRoleWithPermissions(Role $role, array $data)
    {
        $data['name'] = $data['name'] ?? $role->name;
        $role->update([
            'name' => $data['name'],
        ]);
        $role->syncPermissions($data['permissions']);
        return $role;
    }
}
