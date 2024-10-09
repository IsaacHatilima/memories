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
                'required',
                'string',
                'lowercase',
                'email:rfc' . (!app()->environment('production') ? '' : ',dns'),
                'max:50',
                Rule::unique(User::class)->ignore($userId)
            ]
        ];
    }

    public static function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.string' => 'Email MUST be a string.',
            'email.lowercase' => 'Email MUST be lowercase letters.',
            'email.email' => 'Invalid email format.',
            'email.max' => 'Email is too long.',
            'email.unique' => 'Email is already in use.',
        ];
    }
}
