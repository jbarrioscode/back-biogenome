<?php

namespace App\Repositories\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function all();
    public function getUserById(User $user);
    public function addRoleToUserByID($idUser, $idRole);
    public function inactivateUserById(Request $request, $id);
    public function updatePassword(Request $request);
    public function updateUser(Request $request, $userid = null);
    public function sendCodeMFA(Request $request);
    public function validateCodeMFA(Request $request);
}
