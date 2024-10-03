<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'date_of_birth' => ['date'],
            'gender' => ['string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
