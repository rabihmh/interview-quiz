<?php

namespace App\Actions\Fortify\Validations;

use Laravel\Fortify\Rules\Password;

trait PasswordValidationRule
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function passwordRules(): array
    {
        return ['required', 'string', new Password, 'confirmed'];
    }
}
