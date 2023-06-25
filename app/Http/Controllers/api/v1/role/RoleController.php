<?php

namespace App\Http\Controllers\api\v1\role;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\permission\UpdatePermissionRequest;
use App\Http\Requests\api\v1\role\StoreRoleRequest;
use App\Http\Requests\api\v1\role\UpdateRoleRequest;
use App\Repositories\api\v1\role\RoleRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->roleRepository->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        return $this->roleRepository->store($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return $this->roleRepository->show($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        return $this->roleRepository->update($request->all(), $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        return $this->roleRepository->destroy($role);
    }
}
