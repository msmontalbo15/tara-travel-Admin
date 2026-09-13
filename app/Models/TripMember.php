<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripMember extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    // Table only has joined_at/last_seen, no created_at/updated_at pair.
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'roles' => 'array',
            'location_sharing' => 'boolean',
            'joined_at' => 'datetime',
            'last_seen' => 'datetime',
        ];
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(TravelUser::class, 'user_id');
    }
}
