<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\UserPasswordHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {

        Validator::make($input, [
            'firstName' => ['required', 'string', 'max:60'],
            'middleName' => ['string', 'max:60'],
            'lastName' => ['required', 'string', 'max:60'],
            'surName' => ['string', 'max:60'],
            'username' => ['required', 'string', 'max:20', Rule::unique(User::class)],
            'document' => ['required', 'max:25'],
            'phone' => ['max:13'],
            'address' => ['string'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'doc_type_id' => ['required'],
        ])->validate();

        $user = User::create([
            'firstName' => $input['firstName'],
            'middleName' => $input['middleName'],
            'lastName' => $input['lastName'],
            'surName' => $input['surName'],
            'username' => $input['username'],
            'document' => $input['document'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'doc_type_id' => $input['doctype_id'],
            'passwordExpirationDate' => Carbon::now()->addMonths(2),
            'user_id' => null,
        ]);

        $userPwHistory = new UserPasswordHistory();
        $userPwHistory->user_id = $user->id;
        $userPwHistory->password = $user->password;

        $user->passwords()->save($userPwHistory);

        return $user;
        /*Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);*/
    }
}
