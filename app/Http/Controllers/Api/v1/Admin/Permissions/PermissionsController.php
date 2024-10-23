<?php

namespace App\Http\Controllers\Api\v1\Admin\Permissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Repositories\Permission\Interfaces\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    //
    //* Initializing Variables */
    private PermissionRepositoryInterface $permissionRepository;

    /* Construct */
    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getPermissionList()
    {

        try {
            return $this->permissionRepository->all();
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function savePermission(PermissionRequest $request)
    {
        try {

            return $this->permissionRepository->savePermission($request);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function inactivatePermissionById($id = null)
    {

        try {

            return $this->permissionRepository->inactivatePermissionById($id);
        } catch (\Throwable $th) {
            return $th;
        }
    }

}
