<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = ["email", "role", "author_id", "organization_id"];

    public function author()
    {
        return $this->belongsTo(User::class, "author_id");
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, "organization_id");
    }
}
