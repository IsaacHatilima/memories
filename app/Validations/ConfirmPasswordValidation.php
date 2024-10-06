<?php

namespace App\Validations;

class ConfirmPasswordValidation
{
    public static function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'current_password',
            ]
        ];
    }
}
