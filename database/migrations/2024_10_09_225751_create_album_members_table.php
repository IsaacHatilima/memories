<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('album_members', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id');
            $table->foreignId('user_id');
            $table->foreignId('album_id');
            $table->foreignId('created_by');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('album_members');
    }
};
