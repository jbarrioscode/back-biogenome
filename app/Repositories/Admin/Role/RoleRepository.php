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

            if (empty($roles)) return $this->error("No se encontraron Roles", 204);

            return $this->success($roles, count($roles), "Roles Retornados!", 200);
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

            if (!$role) return $this->error("Error al crear el Role", 204);

            if ($request->permissions) {

                $role->syncPermissions($request->permissions);
            }

            return $this->success($role, 1, "Rol creado Correctamente!", 201);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 204, "");
        }
    }

    public function modifyRoleById(Request $request, $id): JsonResponse
    {
        try {

            $role = Role::findById($id);

            if (!$role) return $this->error("No se encontro ningun permiso con este ID", 204);

            if (!$request->name) return $this->error("El parametro NOMBRE no debe estar vacio", 400);

            $role->name = strtoupper($request->name);

            if (!$role->update()) return $this->error("Ha ocurrido un error al modificar el ROL" . " " . $request->name, 500);

            if (count($request->permissions) > 0) {

                $role->syncPermissions($request->permissions);
            }

            return $this->success($role, "Rol Actualizado Correctamente!", 201);
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

            if (!$id) return $this->error("El parametro ID no debe estar vacio", 400);

            $role = Role::findById($id);

            if (!$role) return $this->error("No encontramos ningun rol con este ID", 204);

            if (!$role->delete()) return $this->error("Ha ocurrido un error al eliminar el rol", 500);

            return $this->success("", 1, "Rol Eliminado Correctamente!", 201);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 204, "");
        }
    }
}
