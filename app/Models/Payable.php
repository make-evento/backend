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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, "supplier_id");
    }

    public function todoCard()
    {
        return $this->belongsTo(TodoCard::class, "todo_card_id");
    }

    public function installments()
    {
        return $this->morphMany(Installment::class, "installmentable");
    }
}
