<?php

namespace App\Policies;

use App\Models\Album;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlbumPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return (bool) $user;
    }

    public function view(User $user): bool
    {
        return (bool) $user;
    }

    public function create(User $user): bool
    {
        return (bool) $user;
    }

    public function update(User $user, Album $album): bool
    {
        return $album->user->id === $user->id;
    }

    public function delete(User $user, Album $album): bool
    {
        return $album->user->id === $user->id;
    }

    public function restore(User $user, Album $album): bool
    {
        return $album->user->id === $user->id;
    }

    public function forceDelete(User $user, Album $album): bool
    {
        return $album->user->id === $user->id;
    }
}
