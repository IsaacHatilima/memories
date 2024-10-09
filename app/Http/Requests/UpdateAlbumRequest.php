<?php

namespace App\Http\Requests;

use App\Models\Album;
use App\Validations\AlbumValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAlbumRequest extends FormRequest
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
        return array_merge(
            AlbumValidation::rules(),
            [
                'name' => ['required', Rule::unique(Album::class)->ignore($this->route('album'))]
            ]
        );
    }
}
