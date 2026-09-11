<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LogicException;

class Page extends Model
{
    use HasFactory;
    use HasUniqueKey;

    public const SYSTEM_KEYS = [
        'home',
        'chi-sono',
        'contatti',
    ];

    protected $fillable = [
        'legacy_drupal_id',
        'key',
        'title',
        'content',
        'is_published',
        'seo_title',
        'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (Page $page): void {
            if ($page->isSystemPage()) {
                throw new LogicException('Questa pagina di sistema non può essere eliminata.');
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'key';
    }

    public function isSystemPage(): bool
    {
        return in_array($this->key, self::SYSTEM_KEYS, true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}