<?php

namespace App\Http\Requests;

use App\Validations\AlbumValidation;
use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
{
    public function rules(): array
    {
        return array_merge(
            AlbumValidation::rules(),
            [
                'name' => ['required', 'unique:albums,name']
            ]
        );
    }

    public function authorize(): bool
    {
        return true;
    }
}
