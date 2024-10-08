<?php

namespace App\Services;

use App\Models\Album;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AlbumService
{
    private User $user;
    function __construct()
    {
        $this->user = Auth::user();
    }

    public function createAlbum($request)
    {
        return Album::create([
            'user_id' => $this->user->id,
            'name' => strtoupper($request->name),
            'description' => $request->description,
        ]);
    }

    public function updateAlbum($request,$album)
    {
        $album->name = strtoupper($request->name);
        $album->description = $request->description;
        return $album->save();
    }
}
