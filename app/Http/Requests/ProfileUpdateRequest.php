<?php

namespace App\Http\Requests;

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
            (new RequiredInputValidation('first_name'))->rules(),
            (new RequiredInputValidation('last_name'))->rules(),
            UpdateWithEmailValidation::rules($this->user()->id),
            [
                'date_of_birth' => ['nullable', 'date', 'date_format:Y-m-d'],
                'gender' => ['nullable', 'in:male,female, diverse'],
            ]
        );
    }

    public function messages(): array
    {
        return array_merge(
            (new RequiredInputValidation('first_name'))->messages(),
            (new RequiredInputValidation('last_name'))->messages(),
            [
                'date_of_birth.date' => 'Value must be a valid date.',
                'date_of_birth.regex' => 'Invalid date format.',

                'gender.in' => 'Invalid gender.',

            ]
        );
    }
}
