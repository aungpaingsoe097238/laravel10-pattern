<?php

namespace App\Http\Controllers\api\v1\permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\permission\StorePermissionRequest;
use App\Http\Requests\api\v1\permission\UpdatePermissionRequest;
use App\Repositories\api\v1\permission\PermissionRepository;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
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
        return $this->permissionRepository->update($request->all(), $permission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        return $this->permissionRepository->destroy($permission);
    }
}
