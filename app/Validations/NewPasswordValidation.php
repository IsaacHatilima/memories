<?php

namespace App\Validations;

class NewPasswordValidation
{
    public static function rules(): array
    {
        return [
            'password' => [
                'required',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@?]).*$/',
                'min:8',
                'required_with:password_confirmation',
                'same:password_confirmation',
            ],
            'password_confirmation' => [
                'required',
                'same:password',
            ]
        ];
    }

    public static function messages(): array
    {
        return [
            'password.required' => 'New password is required.',
            'password.regex' => 'New password must contain at least one upper and lower case letter, one number, and one special character (!, $, #, %, @, ?).',
            'password.min' => 'New password must be at least 8 characters long.',
            'password.required_with' => 'New password confirmation is required.',
            'password.same' => 'Password and confirmation must match.',

            'password_confirmation.required' => 'Please confirm your new password.',
            'password_confirmation.same' => 'Password confirmation does not match the new password.',
        ];
    }
}
