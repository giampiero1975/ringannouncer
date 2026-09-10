<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;
    use HasUniqueSlug;

    protected $fillable = [
        'legacy_drupal_id',
        'title',
        'slug',
        'description',
        'event_date',
        'venue',
        'city',
        'country',
        'weight_category',
        'cover_image',
        'is_featured',
        'is_published',
        'seo_title',
        'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'datetime',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeWithEventDate(Builder $query): Builder
    {
        return $query->whereNotNull('event_date');
    }

    public function scopeOrderByEventDate(Builder $query, string $direction = 'asc'): Builder
    {
        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        return $query
            ->orderByRaw('event_date is null')
            ->orderBy('event_date', $direction)
            ->orderBy('id', $direction);
    }

    public function locationLabel(): string
    {
        return collect([$this->venue, $this->city])
            ->filter()
            ->unique()
            ->implode(' · ') ?: 'Location da definire';
    }
}
