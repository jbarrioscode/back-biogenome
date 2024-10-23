<?php

namespace App\Http\Controllers\Api\v1\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Repositories\Role\Interfaces\RoleRepositoryInterface;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    //
    /* Initializing Variables */
    private RoleRepositoryInterface $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getRoleList(){

        try {
            return $this->roleRepository->all();
        } catch (\Throwable $th) {
            return $th;
        }

    }


    public function saveRole(RoleRequest $request){

        try {

            return $this->roleRepository->saveRole($request);

        } catch (\Throwable $th) {
            return $th;
        }

    }

    public function modifyRoleById(Request $request, $id) {

        try {

            return $this->roleRepository->modifyRoleById($request, $id);

        } catch (\Throwable $th) {
            return $th;
        }

    }

    public function inactivateRoleById($id = null){

        try {

            return $this->roleRepository->inactivateRoleById($id);

        } catch (\Throwable $th) {
            return $th;
        }

    }

}
