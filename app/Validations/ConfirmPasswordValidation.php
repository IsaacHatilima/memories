<?php

namespace App\Validations;

class ConfirmPasswordValidation
{
    public static function rules(): array
    {
        return [
            'password' => [
                'required',
                'current_password',
            ]
        ];
    }

    public static function messages(): array
    {
        return [
            'password.required' => 'Password is required.',
            'password.current_password' => 'Password is not correct.'
        ];
    }
}
