<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'permission_list',
            'permission_create',
            'permission_delete',
            'permission_edit',
            'role_list',
            'role_create',
            'role_delete',
            'role_edit',
            'post_list',
            'post_create',
            'post_edit',
            'post_delete',
            'category_list',
            'category_create',
            'category_edit',
            'category_delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'api',
            ]);
        }
    }
}
