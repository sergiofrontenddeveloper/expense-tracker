<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    protected $fillable = [
        'user_id',
        'filename',
        'original_name',
        'file_path',
        'mime_type',
        'size',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
