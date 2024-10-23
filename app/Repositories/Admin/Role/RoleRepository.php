<?php

namespace App\Repositories\Admin\Role;

use App\Http\Requests\Admin\Role\RoleRequest;
use App\Traits\RequestResponseFormatTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    // Importing Trait
    use RequestResponseFormatTrait;

    public function all(): JsonResponse
    {
        try {

            $roles = Role::with('permissions')->get();

            if (empty($roles)) return $this->error("We did not find Any Role", 204);

            return $this->success($roles, count($roles), "Roles Returned!", 200);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 204, "");
        }
    }

    public function saveRole(RoleRequest $request): JsonResponse
    {
        try {

            $request->validated();

            $role = Role::create([
                'name' => strtoupper($request->name)
            ]);

            if (!$role) return $this->error("Error creating Role", 204);

            if ($request->permissions) {

                $role->syncPermissions($request->permissions);
            }

            return $this->success($role, 1, "Role created Successfully!", 201);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 204, "");
        }
    }

    public function modifyRoleById(Request $request, $id): JsonResponse
    {
        try {

            $role = Role::findById($id);

            if (!$role) return $this->error("We did not find Any Permission", 204);

            if (!$request->name) return  $this->error("Name Parameter Cannot be Empty!", 500);

            $role->name = strtoupper($request->name);

            if (!$role->update()) return $this->error("An error Ocurred while Updating the Role" . " " . $request->name, 500);

            if (count($request->permissions) > 0) {

                $role->syncPermissions($request->permissions);
            }

            return $this->success($role, "Role updated Successfully!", 200);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 204, "");
        }
    }

    public function removeOnlyOnePermission(Request $request, $id)
    {
        // TODO: Implement removeOnlyOnePermission() method.
    }

    public function inactivateRoleById($id = null): JsonResponse
    {
        try {

            if (!$id) return $this->error("ID parameter cannot be Empty!", 500);

            $role = Role::findById($id);

            if (!$role) return $this->error("We did not find Any Permission", 204);

            if (!$role->delete()) return $this->error("An error Ocurred while Removing the Role", 500);

            return $this->success("", 1, "Role Removed Successfully!", 200);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 204, "");
        }
    }
}
