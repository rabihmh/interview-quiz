<?php

namespace App\Actions\Fortify\Services;

use App\Actions\Fortify\Validations\UserValidationRules;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CreateUser
{
    public UserValidationRules $rules;

    public function __construct(UserValidationRules $validationRules)
    {
        $this->rules = $validationRules;
    }

    /**
     * @throws ValidationException
     */
    public function createUser(array $input): User
    {
        Validator::make($input, $this->rules->userRules())->validate();
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function createAdmin(array $input): Admin
    {
        Validator::make($input, $this->rules->userRules())->validate();
        return Admin::create([
            'name' => $input['name'],
            'username' => Str::slug($input['name']),
            'phone' => $input['phone'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
