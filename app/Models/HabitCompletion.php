<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HabitCompletion extends Model
{
    protected $fillable = [
        'completed_on',
    ];

    protected function casts(): array
    {
        return [
            'completed_on' => 'date',
        ];
    }

    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class);
    }
}