<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'title',
        'youtube_id',
        'description',
        'thumbnail',
        'published_at',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public static function extractYoutubeId(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $value = trim($value);

        if (preg_match('~(?:youtu\.be/|youtube(?:-nocookie)?\.com/(?:embed/|watch\?v=|shorts/))([A-Za-z0-9_-]{6,})~i', $value, $matches)) {
            return $matches[1];
        }

        if (preg_match('~^[A-Za-z0-9_-]{6,}$~', $value)) {
            return $value;
        }

        return $value;
    }

    public function setYoutubeIdAttribute(?string $value): void
    {
        $this->attributes['youtube_id'] = self::extractYoutubeId($value);
    }
}
