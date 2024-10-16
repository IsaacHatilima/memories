<?php

namespace App\Http\Requests;

use App\Validations\NewPasswordValidation;
use Illuminate\Foundation\Http\FormRequest;

class SetPasswordOnGoogleSignUp extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return NewPasswordValidation::rules();
    }
}
