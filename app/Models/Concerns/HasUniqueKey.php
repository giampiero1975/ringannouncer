<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasUniqueKey
{
    public static function uniqueKey(string $title, ?int $ignoreId = null, string $fallback = 'pagina'): string
    {
        $baseKey = Str::slug($title) ?: $fallback;
        $key = $baseKey;
        $suffix = 2;

        while (static::query()
            ->where('key', $key)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()
        ) {
            $key = "{$baseKey}-{$suffix}";
            $suffix++;
        }

        return $key;
    }
}
