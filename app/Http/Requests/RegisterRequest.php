<?php

namespace App\Http\Requests;

use App\Validations\NewEmailValidation;
use App\Validations\NewPasswordValidation;
use App\Validations\RequiredInputValidation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(
            NewEmailValidation::rules(),
            NewPasswordValidation::rules(),
            RequiredInputValidation::rules('first_name'),
            RequiredInputValidation::rules('last_name'),
        );
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.string' => 'Email MUST be a string.',
            'email.lowercase' => 'Email MUST be lowercase letters.',
            'email.email' => 'Invalid email format.',
            'email.max' => 'Email is too long.',
            'email.unique' => 'Email is already in use.',


            'password.required' => 'Password is required.',
            'password.regex' => 'Password must contain at least one upper and lower case letter, one number, and one special character (!, $, #, %, @, ?).',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.required_with' => 'Password confirmation is required.',
            'password.same' => 'Password and confirmation must match.',

            'password_confirmation.required' => 'Please confirm your password.',
            'password_confirmation.same' => 'Password confirmation does not match the new password.',

            'first_name.required' => 'First Name is required.',
            'first_name.string' => 'First Name MUST be a string.',
            'last_name.required' => 'Last Name is required.',
            'last_name.string' => 'Last Name MUST be a string.',
        ];
    }
}
