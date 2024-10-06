<?php

namespace App\Http\Requests;

use App\Validations\NewPasswordValidation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(
            [
                'current_password' => [
                    'required',
                    'current_password',
                ]
            ],
            NewPasswordValidation::rules(),

        );
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Current password is required.',
            'current_password.current_password' => 'Your current password is incorrect.',

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
