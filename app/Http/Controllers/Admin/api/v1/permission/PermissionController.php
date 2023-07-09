<?php

namespace App\Http\Controllers\Admin\api\v1\permission;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\Admin\api\v1\permission\PermissionResource;
use App\Repositories\Admin\api\v1\permission\PermissionRepository;
use App\Http\Resources\Admin\api\v1\permission\PermissionCollection;
use App\Http\Requests\Admin\api\v1\permission\StorePermissionRequest;
use App\Http\Requests\Admin\api\v1\permission\UpdatePermissionRequest;

class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete');
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
