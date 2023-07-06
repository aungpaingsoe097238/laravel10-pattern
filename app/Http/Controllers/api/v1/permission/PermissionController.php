<?php

namespace App\Http\Controllers\api\v1\permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Repositories\api\v1\permission\PermissionRepository;
use App\Http\Requests\api\v1\permission\StorePermissionRequest;
use App\Http\Requests\api\v1\permission\UpdatePermissionRequest;

class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->middleware('permission:permission_list|permission_create|permission_edit|permission_delete');
        $this->permissionRepository = $permissionRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->permissionRepository->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        return $this->permissionRepository->store($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return $this->permissionRepository->show($permission);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        return $this->permissionRepository->update($request->validated(), $permission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        return $this->permissionRepository->destroy($permission);
    }


    public function getRolePermission($id)
    {
        return $this->permissionRepository->getRolePermission($id);
    }

    public function getRolePermissions($id)
    {
        return $this->permissionRepository->getRolePermissions($id);
    }
}
