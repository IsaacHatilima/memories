<?php

namespace App\Validations;

use App\Models\User;

class NewEmailValidation
{
    public static function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'lowercase',
                'email:rfc,dns',
                'max:255',
                'unique:'.User::class
            ]
        ];
    }
}
