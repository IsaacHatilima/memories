<?php

namespace App\Models;

use App\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use SoftDeletes, HasFactory, ModelHelpers;

    protected $guarded = [
        'id',
        'public_id',
    ];

    protected $hidden = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
