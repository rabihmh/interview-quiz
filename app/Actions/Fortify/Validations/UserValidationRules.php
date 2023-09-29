<?php

namespace App\Actions\Fortify\Validations;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserValidationRules
{
    use PasswordValidationRule;

    public function userRules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
                Rule::unique(Admin::class),
            ],
            'password' => $this->passwordRules(),
        ];

        if (request()->has('phone')) {
            $rules['phone'] = 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8';
        } else {
            $rules['phone'] = 'nullable';
        }

        return $rules;
    }
}
