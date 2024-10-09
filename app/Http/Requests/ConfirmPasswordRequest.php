<?php

namespace App\Http\Requests;

use App\Validations\ConfirmPasswordValidation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmPasswordRequest extends FormRequest
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
        return ConfirmPasswordValidation::rules();
    }

    public function messages(): array
    {
        return ConfirmPasswordValidation::messages();
    }
}
