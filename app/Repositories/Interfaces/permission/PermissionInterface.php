<?php

namespace App\Repositories\Interfaces\permission;

use PhpParser\Node\Expr\Cast\String_;
use Spatie\Permission\Models\Permission;

interface PermissionInterface
{
    public function index();
    public function show(Permission $permission);
    public function store(array $data);
    public function update(array $data, Permission $permission);
    public function destroy(Permission $permission);
    public function getRolePermission($id);
    public function getRolePermissions($id);
}
