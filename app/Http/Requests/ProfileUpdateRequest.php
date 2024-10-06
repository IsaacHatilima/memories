<?php

namespace App\Http\Requests;

use App\Validations\NewEmailValidation;
use App\Validations\RequiredInputValidation;
use App\Validations\UpdateWithEmailValidation;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return array_merge(
            NewEmailValidation::rules(),
            RequiredInputValidation::rules('first_name'),
            RequiredInputValidation::rules('last_name'),
            UpdateWithEmailValidation::rules($this->user()->id),
            [
                'date_of_birth' => ['nullable', 'date', 'date_format:Y-m-d'],
                'gender' => ['nullable', 'in:male,female'],
            ]
        );
    }
}
