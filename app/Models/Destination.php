<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Maps to public.destinations — the curated cards the app's Explore tab
 * reads from. This is the one table where the admin dashboard is the
 * primary editor (everything else here is oversight of traveler-generated
 * data), so it gets full create/update/delete.
 */
class Destination extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'country',
        'distance_from_metro',
        'best_mode',
        'avg_cost_range',
        'photo_emoji',
        'tag',
        'description',
        'is_trending',
        'is_weekend_getaway',
        'is_recommended',
        'recommended_reason',
        'best_time_to_visit',
    ];

    protected function casts(): array
    {
        return [
            'is_trending' => 'boolean',
            'is_weekend_getaway' => 'boolean',
            'is_recommended' => 'boolean',
        ];
    }
}
