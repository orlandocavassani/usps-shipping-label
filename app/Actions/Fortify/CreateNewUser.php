<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'phone' => $this->getPhoneNumber($input),
            'street' => $input['street'],
            'city' => $input['city'],
            'state' => mb_strtoupper($input['state']),
            'zip' => $input['zip'],
            'country' => mb_strtoupper($input['country']),
        ]);
    }

    private function getPhoneNumber(array $input): string
    {
        return preg_replace('/\D/', '', $input['phone']);
    }
}
