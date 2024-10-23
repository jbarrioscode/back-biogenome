<?php

namespace App\Repositories\Permission;

use App\Http\Requests\PermissionRequest;
use App\Repositories\Permission\Interfaces\PermissionRepositoryInterface;
use App\Traits\AuthenticationTrait;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements Interfaces\PermissionRepositoryInterface
{

    use AuthenticationTrait;

    public function all()
    {
        // TODO: Implement all() method.
        try {

            $permissions = Permission::all();

            if (empty($permissions)) return $this->error("We did not find Any Permission", 204);

            return $this->success($permissions, count($permissions), "Permissions Returned!", 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function savePermission(PermissionRequest $request)
    {
        // TODO: Implement savePermission() method.
        try {

            $request->validated();

            /* if ($permission) return $this->error("A permission was found with same Name", 500); */

            $permissions = Permission::create([
                'name' => strtoupper($request->name),
            ]);

            if (!$permissions) return $this->error("Error creating Permission", 204);

            return $this->success($permissions, 1,"Permission Created Successfully!", 201);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function inactivatePermissionById($id = null)
    {
        // TODO: Implement inactivatePermissionById() method.
        try {

            if(!$id) return $this->error("ID parameter cannot be Empty!", 500);

            $permission = Permission::findById($id);

            if (!$permission) return $this->error("We did not find Any Permission", 204);

            if (!$permission->delete()) return $this->error("An error Ocurred while Removing the Permission", 500);

            return $this->success("", "Permission Removed Successfully!", 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
