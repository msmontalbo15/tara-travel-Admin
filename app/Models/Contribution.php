<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Read-only from the admin dashboard (surfaced on the trip detail page).
 * confirmed_by is FK-constrained to public.users (a fellow trip member,
 * usually the treasurer) so this model doesn't expose a way to confirm
 * from the admin side — that FK can't validly hold an Admin's id.
 */
class Contribution extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'due_date' => 'date',
            'paid_at' => 'datetime',
            'confirmed' => 'boolean',
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
