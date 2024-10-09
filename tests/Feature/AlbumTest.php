<?php

use App\Models\Album;
use App\Models\User;

test('user can view album manager page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('albums.index'));

    $response->assertStatus(200);
});

test('user can create album', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('albums.store'), [
        'name' => 'Vienna',
        'description' => 'It was lit',
    ]);

    $response->assertStatus(200);
});

test('user can delete album', function () {
    $user = User::factory()->create();
    $album = Album::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->delete(route('albums.destroy', $album->public_id));

    $response->assertStatus(302);
    $this->assertDatabaseMissing('albums', [
        'public_id' => $album->public_id,
    ]);
});

test('user can archive album', function () {
    $user = User::factory()->create();
    $album = Album::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->patch(route('albums.archive', $album->public_id));

    $response->assertStatus(302);

});

test('user can restore album', function () {
    $user = User::factory()->create();
    $album = Album::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->patch(route('albums.restore', $album->public_id));

    $response->assertStatus(302);

});

test('user can update album', function () {
    $user = User::factory()->create();
    $album = Album::factory()->create([
        'user_id' => $user->id,
    ]);
    $response = $this
        ->actingAs($user)
        ->patch(route('albums.update', $album->public_id), [
            'name' => 'Album',
            'description' => 'This is a description'
        ]);

    $album->refresh();

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('albums.index'));
    $this->assertSame('ALBUM', $album->name);
    $response->assertStatus(302);

});
