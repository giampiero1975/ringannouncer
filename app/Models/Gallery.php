<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'legacy_drupal_id',
        'event_id',
        'title',
        'slug',
        'description',
        'cover_image',
        'published_at',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }
}
