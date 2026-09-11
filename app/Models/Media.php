<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'event_id',
        'legacy_file_id',
        'type',
        'file_path',
        'original_name',
        'title',
        'caption',
        'alt_text',
        'sort_order',
        'show_on_home',
    ];

    protected function casts(): array
    {
        return [
            'show_on_home' => 'boolean',
        ];
    }

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    public function getPublicUrlAttribute(): string
    {
        if (str_starts_with($this->file_path, 'http://') || str_starts_with($this->file_path, 'https://') || str_starts_with($this->file_path, '/')) {
            return $this->file_path;
        }

        if (str_starts_with($this->file_path, 'images/')) {
            return asset($this->file_path);
        }

        return Storage::url($this->file_path);
    }

    public function getThumbnailUrlAttribute(): string
    {
        if (str_starts_with($this->file_path, 'galleries/')) {
            $relativePath = substr($this->file_path, strlen('galleries/'));
            $directory = trim(str_replace('\\', '/', dirname($relativePath)), './');
            $filename = pathinfo($relativePath, PATHINFO_FILENAME).'.webp';
            $thumbnailPath = 'galleries/thumbs/'.($directory !== '' ? $directory.'/' : '').$filename;

            if (Storage::disk('public')->exists($thumbnailPath)) {
                return Storage::url($thumbnailPath);
            }
        }

        return $this->public_url;
    }

    public function getDisplayTitleAttribute(): string
    {
        return $this->title ?: $this->caption ?: $this->alt_text ?: $this->original_name ?: 'Foto gallery';
    }
}