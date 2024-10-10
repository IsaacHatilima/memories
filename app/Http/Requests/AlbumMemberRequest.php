<?php

namespace App\Http\Requests;

use App\Models\Album;
use App\Models\AlbumMember;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AlbumMemberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'exists:users,email',
                function ($attribute, $value, $fail) {
                    // Find the user by email
                    $user = User::firstWhere('email', $value);
                    // Find the album by public_id
                    $album = Album::firstWhere('public_id', request('album_id'));

                    if ($user && $album) {
                        // Check if the user is already in album_members
                        $isMember = AlbumMember::where('user_id', $user->id)
                            ->where('album_id', $album->id)
                            ->exists();

                        // If user is already a member, fail the validation with a custom message
                        if ($isMember) {
                            $fail('The user is already a member of this album.');
                        }
                    }
                },
            ],
            'album_id' => ['required', 'exists:albums,public_id'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'User not found on Memories.',
            'album_id.exists' => 'Album not found.',
        ];
    }

    public function authorize(): bool
    {
        return (bool) $this->user()->id;
    }
}
