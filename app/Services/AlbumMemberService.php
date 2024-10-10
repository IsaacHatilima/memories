<?php

namespace App\Services;

use App\Models\Album;
use App\Models\AlbumMember;
use App\Models\User;

class AlbumMemberService
{
    public function addMember($request)
    {
        $album = Album::firstWhere('public_id', $request->album_id);
        $user = User::firstWhere('email', $request->email);

        return AlbumMember::create([
            'album_id' => $album->id,
            'user_id' => $user->id,
            'created_by' => auth()->user()->id,
        ]);
    }
}
