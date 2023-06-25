<?php

namespace App\Repositories\api\v1\role;

use Spatie\Permission\Models\Role;
use App\Repositories\BaseRepository;
use App\Http\Resources\api\v1\role\RoleResource;
use App\Http\Resources\api\v1\role\RoleCollection;
use App\Repositories\Interfaces\role\RoleInterface;

class RoleRepository implements RoleInterface
{

    protected $with;

    public function __construct()
    {
        $this->with = ['permissions'];
    }

    public function index()
    {
        $roles = Role::with($this->with)
            ->orderBy('id', 'asc');
        if (request()->has('paginate')) {
            $roles = $roles->paginate(request()->get('paginate'));
        } else {
            $roles = $roles->get();
        }
        return new RoleCollection($roles);
    }

    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    public function store(array $data)
    {
        $role = Role::create([
            'name'   => $data['name']
        ]);
        if (isset($data['permission']) && $data['permission']) {
            $role->syncPermissions($data['permission']);
        }
        return new RoleResource($role);
    }

    public function update(array $data, Role $role)
    {
        $data['name'] = isset($data['name']) ? $data['name'] : $role->name;

        $role->update([
            'name' => $data['name'],
        ]);

        return new RoleResource($role);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return BaseRepository::deleteSuccess('role id ' . $role->id . ' delete successfully');
    }
}
