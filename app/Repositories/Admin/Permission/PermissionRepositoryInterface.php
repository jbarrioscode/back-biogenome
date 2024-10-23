<?php

namespace App\Repositories\Admin\Permission;

use App\Http\Requests\Admin\Permission\PermissionRequest;

interface PermissionRepositoryInterface
{
    public function all();
    public function savePermission(PermissionRequest $request);
    public function inactivatePermissionById($id = null);
}
