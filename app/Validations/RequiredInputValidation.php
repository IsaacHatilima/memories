<?php

namespace App\Validations;

class RequiredInputValidation
{
    private string $attribute;

    public function __construct(string $attribute)
    {
        $this->attribute = $attribute;
    }

    public function rules(): array
    {
        return [
            $this->attribute => [
                'required',
                'string',
                'min:2'
            ]
        ];
    }

    public function messages(): array
    {
        $formattedAttribute = ucwords(str_replace('_', ' ', $this->attribute));

        return [
            $this->attribute.'.required' => $formattedAttribute.' is required.',
            $this->attribute.'.string' => $formattedAttribute.' MUST be a string.',
        ];
    }
}
