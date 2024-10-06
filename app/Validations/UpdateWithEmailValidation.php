<?php

namespace App\Validations;

use App\Models\User;
use Illuminate\Validation\Rule;

class UpdateWithEmailValidation
{
    public static function rules(int $userId): array
    {
        return [
            'email' => [
                'required', 'string', 'lowercase', 'email:rfc,dns', 'max:255',
                Rule::unique(User::class)->ignore($userId)
            ]
        ];
    }
}
