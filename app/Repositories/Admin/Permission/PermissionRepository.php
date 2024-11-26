<?php

namespace App\Repositories\Admin\Permission;

use App\Http\Requests\Admin\Permission\PermissionRequest;
use App\Traits\RequestResponseFormatTrait;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{

    // Importing Trait
    use RequestResponseFormatTrait;

    public function all(): JsonResponse
    {
        try {

            $permissions = Permission::all();

            if (empty($permissions)) return $this->error("No se encontraron PERMISOS", 204);

            return $this->success($permissions, count($permissions), "Permisos retornados!", 200);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 204, "");
        }
    }

    public function savePermission(PermissionRequest $request): JsonResponse
    {
        try {

            $request->validated();

            $permissions = Permission::create([
                'name' => strtoupper($request->name),
            ]);

            if (!$permissions) return $this->error("Error al CREAR el permiso", 204);

            return $this->success($permissions, 1,"Permiso CREADO correctamente!", 201);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 204, "");
        }
    }

    public function updatePermission(PermissionRequest $request, $permission_id): JsonResponse
    {
        // TODO: Implement updatePermission() method.
        try {

            if(!$permission_id) return $this->error("ID no puede ir vacio!", 400);

            $permission = Permission::findById($permission_id);

            if (!$permission) return $this->error("NO se encontro ningun permiso con este ID", 204);

            $permission->name = $request->name;

            if (!$permission->update()) return $this->error("No se puede ACTUALIZAR el permiso", 500);

            return $this->success($permission, 1,"Permiso ACTUALIZADO correctamente!", 201);


        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 204, "");
        }
    }

    public function inactivatePermissionById($id = null): JsonResponse
    {
        try {

            if(!$id) return $this->error("ID no puede ir vacio!", 400);

            $permission = Permission::findById($id);

            if (!$permission) return $this->error("NO se encontro ningun permiso con este ID", 204);

            if (!$permission->delete()) return $this->error("No se puede INACTIVAR el permiso", 500);

            return $this->success([], 1,"Permiso INACTIVADO correctamente!", 200);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 204, "");
        }
    }
}
