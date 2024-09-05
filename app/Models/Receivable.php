<?php

namespace App\Models;

use App\InstallmentStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receivable extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        "contract_id",
        "customer_id",
        "amount",
        "status",
        "payment_type",
        "installments",
    ];

    protected $casts = [
        "status" => InstallmentStatus::class,
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, "customer_id");
    }

    public function sender()
    {
        return $this->morphTo();
    }

    public function installmentsDetails()
    {
        return $this->morphMany(Installment::class, "installmentable");
    }
}
