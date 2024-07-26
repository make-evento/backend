<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierContact extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ["name", "email", "phone", "supplier_id"];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, "supplier_id");
    }
}
