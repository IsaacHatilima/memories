<?php

namespace App\Validations;

class AlbumValidation
{
    public static function rules(): array
    {
        return [
            'description' => ['nullable'],
            'thumbnail' => ['nullable'],
        ];
    }
}
