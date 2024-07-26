<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        "street",
        "number",
        "complement",
        "neighborhood",
        "city",
        "state",
        "zip_code",
    ];

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, "address_id");
    }
}
