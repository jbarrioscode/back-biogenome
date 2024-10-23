<?php

namespace App\Repositories\Role\Interfaces;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;

interface RoleRepositoryInterface
{
    public function all();
    public function saveRole(RoleRequest $request);

    /* Function to Modify RoleName and Sync Permissions */
    public function modifyRoleById(Request $request, $id);

    /* Function to Remove Only One Permission */
    public function removeOnlyOnePermission(Request $request, $id);

    /* Function to inactivateRoleById */
    public function inactivateRoleById($id = null);
}
