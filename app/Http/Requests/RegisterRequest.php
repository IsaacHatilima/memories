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
            (new RequiredInputValidation('first_name'))->rules(),
            (new RequiredInputValidation('last_name'))->rules()
        );
    }

    public function messages(): array
    {
        return array_merge(
            NewEmailValidation::messages(),
            (new RequiredInputValidation('first_name'))->messages(),
            (new RequiredInputValidation('last_name'))->messages(),
            [
                'password.required' => 'Password is required.',
                'password.regex' => 'Password must contain at least one upper and lower case letter, one number, and one special character (!, $, #, %, @, ?).',
                'password.min' => 'Password must be at least 8 characters long.',
                'password.required_with' => 'Password confirmation is required.',
                'password.same' => 'Password and confirmation must match.',

                'password_confirmation.required' => 'Please confirm your password.',
                'password_confirmation.same' => 'Password confirmation does not match the new password.',

            ]
        );
    }
}
