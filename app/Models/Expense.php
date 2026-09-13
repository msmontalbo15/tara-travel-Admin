<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'status',
        'approved_by',
        'rejected_by',
        'rejection_note',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'split_meta' => 'array',
        ];
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function paidBy(): BelongsTo
    {
        return $this->belongsTo(TravelUser::class, 'paid_by_user_id');
    }

    /**
     * Marks approved. The `expense-approved` Supabase Edge Function is
     * wired to a database webhook on this table's UPDATE, so it fires the
     * traveler's push notification automatically — this method only needs
     * to change the row.
     *
     * approved_by/rejected_by are foreign keys into public.users (trip
     * members — treasurer/organizer). An Admin's id lives in a different
     * table and isn't a valid value there, so admin-side approvals leave
     * both columns null rather than writing a reference the database
     * would reject. Which admin acted is left to Laravel's own auth log.
     */
    public function approve(): void
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => null,
            'rejected_by' => null,
            'rejection_note' => null,
        ]);
    }

    public function reject(?string $note = null): void
    {
        $this->update([
            'status' => 'rejected',
            'approved_by' => null,
            'rejected_by' => null,
            'rejection_note' => $note,
        ]);
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'approved' => 'emerald',
            'rejected' => 'rose',
            default => 'amber',
        };
    }
}
