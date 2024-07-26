<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ["role", "organization_id", "user_id"];

    public function organization()
    {
        return $this->belongsTo(Organization::class, "organization_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
