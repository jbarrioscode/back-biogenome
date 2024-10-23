<?php

namespace App\Http\Controllers\Api\v1\Admin\Users;

use App\Http\Controllers\Controller;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    /** Initializing variables */
    private $userRepository;

    /** Using Authentication Middleware */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsersList()
    {
        try {
            return $this->userRepository->all();
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function inactivateUserById(Request $request, $id)
    {
        try {
            return $this->userRepository->inactivateUserById($request, $id);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            return $this->userRepository->updatePassword($request);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateUser(Request $request, $userid = null)
    {
        try {
            return $this->userRepository->updateUser($request, $userid);
        } catch (\Throwable $th) {
            return $th;
        }
    }

}
