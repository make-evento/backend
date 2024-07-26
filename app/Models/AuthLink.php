<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthLink extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ["code", "expires_at", "user_id"];

    protected $casts = [
        "expires_at" => "datetime",
    ];

    public function expired(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->expires_at->isPast(),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
