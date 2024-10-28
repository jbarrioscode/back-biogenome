<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\UserPasswordHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Spatie\Permission\Models\Role;

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
            //'username' => ['required', 'string', 'max:20', Rule::unique(User::class)],
            'document_type_id' => ['required'],
            'document' => ['required', 'max:25'],
            'phone' => ['max:13'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'firstName' => $input['firstName'],
            'middleName' => $input['middleName'],
            'lastName' => $input['lastName'],
            'surName' => $input['surName'],
            //'username' => $input['username'],
            'username' => $this->setUsernameAttribute($input['firstName'], $input['lastName']),
            'document_type_id' => $input['document_type_id'],
            'document' => $input['document'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'passwordExpirationDate' => Carbon::now()->addMonths(2),
            'user_id' => User::with(['doctype'])->where('id', '=', auth()->id())->exists() ? null : auth()->id(),
            'email_verified_at' => Carbon::now(),
        ]);


        $user->assignRole($this->findRole($input['role_id']));

        return $user;
    }

    private function findRole($role)
    {
        $role = Role::findById($role);
        return $role->name;
    }

    private function setUsernameAttribute($first_name, $last_name): string
    {
        $firstName = $first_name;
        $lastName = strtolower($last_name);

        $username = $firstName[0] . $lastName;

        $i = 0;
        while (User::with(['doctype'])->where('username', '=', $username)->exists()) {
            $i++;
            $username = $firstName[0] . $lastName . $i;
        }

        return $username;
    }
}
