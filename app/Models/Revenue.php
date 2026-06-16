<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Revenue extends Model
{
    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'revenue_date',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'revenue_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
