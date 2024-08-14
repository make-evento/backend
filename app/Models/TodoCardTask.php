<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TodoCardTask extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'todo_card_id',
        'content',
        'completed',
    ];

    protected $casts = [
        'completed' => 'boolean',
    ];

    public function card(): BelongsTo
    {
        return $this->belongsTo(TodoCard::class);
    }
}
