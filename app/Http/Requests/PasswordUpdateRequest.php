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
        return array_merge(
            NewPasswordValidation::messages(),
            [
                'current_password.required' => 'Current password is required.',
                'current_password.current_password' => 'Your current password is incorrect.',
            ]
        );
    }
}
