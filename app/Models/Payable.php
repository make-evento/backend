<?php

namespace App\Models;

use App\InstallmentStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payable extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        "supplier_id",
        "todo_card_id",
        "amount",
        "status",
        "payment_type",
        "installments",
    ];

    protected $casts = [
        "status" => InstallmentStatus::class,
    ];

    public function destiny()
    {
        return $this->morphTo();
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function installmentsDetails()
    {
        return $this->morphMany(Installment::class, "installmentable");
    }
}
