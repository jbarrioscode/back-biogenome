<?php

namespace App\Repositories\Permission\Interfaces;

use App\Http\Requests\PermissionRequest;

interface PermissionRepositoryInterface
{
    public function all();
    public function savePermission(PermissionRequest $request);
    public function inactivatePermissionById($id = null);
}
