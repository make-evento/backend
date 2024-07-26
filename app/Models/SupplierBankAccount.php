<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierBankAccount extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        "bank_name",
        "bank_code",
        "agency",
        "account",
        "account_dv",
        "account_type",
        "pix_key",
        "pix_key_type",
        "supplier_id",
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, "supplier_id");
    }
}
