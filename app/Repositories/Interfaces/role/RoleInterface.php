<?php

namespace App\Repositories\Interfaces\role;

use Spatie\Permission\Models\Role;

interface RoleInterface 
{
    public function index();
    public function show(Role $role);
    public function store(array $data);
    public function update(array $data, Role $role);
    public function destroy(Role $role);
}
