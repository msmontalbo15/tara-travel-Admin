<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Maps to public.users — Supabase Auth-managed traveler accounts from the
 * Flutter app. Named TravelUser (not User) to avoid colliding with the
 * admin_users/Admin auth model, and to keep it obvious in every controller
 * and view which "user" is meant.
 *
 * Several columns (phone, gcash_number, health_notes) are app-level
 * AES-encrypted before they ever reach this database. This model never
 * selects or displays their raw values — the admin dashboard has no way
 * to decrypt them, and traveler health/payment data shouldn't be surfaced
 * in a moderation UI even if it could be.
 */
class TravelUser extends Model
{
    protected $table = 'users';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'display_name',
        'home_city',
    ];

    protected $hidden = [
        'phone',
        'gcash_number',
        'health_notes',
        'blood_type',
        'allergies',
        'dietary',
    ];

    protected function casts(): array
    {
        return [
            'allergies' => 'array',
            'dietary' => 'array',
            'share_health_with_org' => 'boolean',
            'is_online' => 'boolean',
            'last_seen' => 'datetime',
        ];
    }

    public function ownedTrips(): HasMany
    {
        return $this->hasMany(Trip::class, 'owner_id');
    }

    public function tripMemberships(): HasMany
    {
        return $this->hasMany(TripMember::class, 'user_id');
    }

    /** True if any of the AES-encrypted health fields have been filled in — shown as a badge, never the values themselves. */
    public function getHasHealthInfoAttribute(): bool
    {
        return filled($this->getRawOriginal('health_notes'))
            || filled($this->getRawOriginal('blood_type'));
    }
}
