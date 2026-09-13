<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settlement extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'status',
        'confirmed_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'confirmed_at' => 'datetime',
        ];
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(TravelUser::class, 'from_user_id');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(TravelUser::class, 'to_user_id');
    }

    /** For dispute resolution — lets an admin confirm a settlement both sides agree happened but never got marked. */
    public function markConfirmed(): void
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'confirmed' => 'emerald',
            'sent' => 'sky',
            default => 'amber',
        };
    }
}
