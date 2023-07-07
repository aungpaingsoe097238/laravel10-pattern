<?php

namespace App\Http\Controllers\api\v1\permission;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Repositories\api\v1\permission\PermissionRepository;
use App\Http\Requests\api\v1\permission\StorePermissionRequest;
use App\Http\Requests\api\v1\permission\UpdatePermissionRequest;
use App\Http\Resources\api\v1\permission\PermissionCollection;
use App\Http\Resources\api\v1\permission\PermissionResource;

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
        $permissions = $this->permissionRepository->getAll();
        return new PermissionCollection($permissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = $this->permissionRepository->create($request->validated());
        return new PermissionResource($permission);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        $permission = $this->permissionRepository->get($permission);
        return new PermissionResource($permission);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission = $this->permissionRepository->update($permission, $request->validated());
        return new PermissionResource($permission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        return $this->permissionRepository->delete($permission);
    }
}
