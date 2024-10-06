<?php

namespace App\Validations;

class RequiredInputValidation
{
    public static function rules(string $attribute): array
    {
        return [
            $attribute => [
                'required',
                'string',
                'min:2'
            ]
        ];
    }
}
