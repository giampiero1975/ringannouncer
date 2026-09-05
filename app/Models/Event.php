<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'legacy_drupal_id',
        'title',
        'slug',
        'description',
        'event_date',
        'event_end_date',
        'status',
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
            'event_end_date' => 'datetime',
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
}
