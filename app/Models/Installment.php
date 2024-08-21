<?php

namespace App\Models;

use App\InstallmentStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        "installmentable_id",
        "installmentable_type",
        "status",
        "installment",
        "amount",
        "due_date",
        "attachment",
        "paid_at",
    ];

    protected $casts = [
        "due_date" => "date",
        "paid_at" => "date",
        "status" => InstallmentStatus::class,
    ];

    public function installmentable()
    {
        return $this->morphTo();
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function contract()
    {
        return $this->morphTo(__FUNCTION__, 'installmentable_type', 'installmentable_id');
    }

    public function todoCard()
    {
        return $this->morphTo(__FUNCTION__, 'installmentable_type', 'installmentable_id');
    }

}
