<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'status',
        'cover_color',
        'cover_emoji',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'budget' => 'decimal:2',
            'transport_meta' => 'array',
            'split_meta' => 'array',
            'invite_expires_at' => 'datetime',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(TravelUser::class, 'owner_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(TripMember::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function settlements(): HasMany
    {
        return $this->hasMany(Settlement::class);
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(Contribution::class);
    }

    public function itineraryStops(): HasMany
    {
        return $this->hasMany(ItineraryStop::class);
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'draft' => 'slate',
            'planned' => 'sky',
            'active' => 'coral',
            'completed' => 'emerald',
            'archived' => 'slate',
            default => 'slate',
        };
    }
}
