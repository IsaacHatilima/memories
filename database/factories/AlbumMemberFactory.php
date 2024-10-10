<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\AlbumMember;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AlbumMemberFactory extends Factory
{
    protected $model = AlbumMember::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'album_id' => Album::factory(),
            'created_by' => User::factory(),
        ];
    }
}
