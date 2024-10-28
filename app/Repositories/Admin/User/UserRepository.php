<?php

namespace App\Repositories\Admin\User;

use App\Models\User;
use App\Traits\RequestResponseFormatTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserRepository implements UserRepositoryInterface
{

    // Importing Trait
    use RequestResponseFormatTrait;

    public function all(): JsonResponse
    {
        $users = User::with(['doctype', 'roles'])
            ->where('users.status', 1)
            ->orderBy('users.firstName', 'ASC')
            ->get();

        if (!$users) return $this->error("No se encontro ningun usuario", 204);

        return $this->success($users, count($users), "Usuarios retornados!", 200);
    }

    public function getUserById(User $user)
    {
        // TODO: Implement getUserById() method.
    }

    public function addRoleToUserByID($idUser, $idRole)
    {
        // TODO: Implement addRoleToUserByID() method.
    }

    public function inactivateUserById(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) return $this->error("We could not Find the User with ID" . $id, 204);
        $user->userStatus = 0;

        if (!$user->delete()) return $this->error("There was an Error Inactivating this User" . $user->id, 500);

        $user->delete();

        return $this->success([], 1, "Usuario Actualizado", 200);
    }

    public function updatePassword(Request $request): JsonResponse
    {

        try {

            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|confirmed'
            ]);

            if (!Hash::check($request->old_password, auth()->user()->password)) {
                return $this->error("Incorrect Old Password", 204, "");
            }

            $user = User::find(auth()->id());

            $passwordTemp = Hash::make($request->new_password);

            $user->password = $passwordTemp;
            $user->passwordExpirationDate = Carbon::now()->addMonths(3);

            if (!$user->save()) return $this->error("No se pudo actualizar la contraseña", 400, "");

            return $this->success([], 1, "Contraseña Actualizada!", 201);

        } catch (\Exception $e) {
            Log::error('Error al actualizar la contraseña', ['errors' => $e->getMessage()]);
            return $this->error("Error al actualizar la contraseña", 500, ['errors' => $e->getMessage()]);
        }
    }

    public function updateUser(Request $request, $userid = null)
    {
        try {

            if (!$userid) return $this->error("Parametro userid no puede estar vacio", 400, "");

            Validator::make($request->all(), [
                'firstName' => ['required', 'string', 'max:60'],
                'middleName' => ['string', 'max:60'],
                'lastName' => ['required', 'string', 'max:60'],
                'surName' => ['string', 'max:60'],
                //'username' => ['required', 'string', 'max:20'],
                'document_type_id' => ['required'],
                'document' => ['required', 'max:25'],
                'phone' => ['max:12'],
                'address' => ['string'],
            ])->validate();

            $user = User::find($userid);

            if (!$user) return $this->error("No se encontro ningun usuario con este ID", 400, "");

            $user->firstName = $request->firstName;
            $user->middleName = $request->middleName;
            $user->lastName = $request->lastName;
            $user->surName = $request->surName;
            //$user->username = $request->username;
            $user->document_type_id = $request->document_type_id;
            $user->document = $request->document;
            $user->phone = $request->phone;
            $user->address = $request->address;
            //$user->email = $request->email;
            $user->syncRoles($request->role_id);

            if (!$user->update()) return $this->error("Error al actualizar el usuario", 500, "");

            return $this->success($user, 1, "Usuario actualizado Correctamente", 201);

        } catch (\Exception $e) {
            Log::error('Error al actualizar el usuario', ['errors' => $e->getMessage()]);
            return $this->error("Error al actualizar el usuario", 500, ['errors' => $e->getMessage()]);
        }
    }

    public function sendCodeMFA(Request $request)
    {
        // TODO: Implement sendCodeMFA() method.
    }

    public function validateCodeMFA(Request $request)
    {
        // TODO: Implement validateCodeMFA() method.
    }
}
