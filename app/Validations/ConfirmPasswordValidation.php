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
}
