<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];
}
