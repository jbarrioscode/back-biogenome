<?php

namespace App\Http\Controllers\Api\v1\Admin\Authentication;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Traits\AuthenticationTrait;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    //
    use AuthenticationTrait;

    public function register(Request $request)
    {
        $user = (new CreateNewUser())->create($request->all());

        if (!$user) return $this->error('Error While Creating User', 500);
        return $this->success($user, 'User Created Succefully!', 201);
    }
}
