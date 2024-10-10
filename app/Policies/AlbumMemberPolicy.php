<?php

namespace App\Policies;

use App\Models\AlbumMember;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlbumMemberPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return (bool)$user;
    }

    public function update(User $user, AlbumMember $albumMember): bool
    {
        return $user->id === $albumMember->user_id;
    }

    public function delete(User $user, AlbumMember $albumMember): bool
    {
        return $user->id === $albumMember->user_id || $user->id === $albumMember->album->user_id;
    }

}
