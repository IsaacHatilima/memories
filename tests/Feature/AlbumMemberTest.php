<?php

use App\Models\Album;
use App\Models\AlbumMember;
use App\Models\User;

test('user can view album details page', function () {
    $user = User::factory()->create();
    $album = Album::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->get(route('albums.show', $album->public_id));
    $response->assertStatus(200);
});

test('user can add members to the album', function () {
    $user = User::factory()->create();
    $member = User::factory()->create();
    $album = Album::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->post(route('album.members.store'), [
        'email' => $member->email,
        'album_id' => $album->public_id,
    ]);
    $response->assertStatus(200);
});

test('user cannot add same member to the album', function () {
    $user = User::factory()->create();
    $member = User::factory()->create();
    $album = Album::factory()->create([
        'user_id' => $user->id,
    ]);
    AlbumMember::factory()->create([
        'user_id' => $member->id,
        'album_id' => $album->id,
        'created_by' => $user->id,
    ]);


    $response = $this->actingAs($user)->post(route('album.members.store'), [
        'email' => $member->email,
        'album_id' => $album->public_id,
    ]);
    $response->assertStatus(302);
    $response->assertSessionHasErrors([
        'email' => 'The user is already a member of this album.',
    ]);
});
