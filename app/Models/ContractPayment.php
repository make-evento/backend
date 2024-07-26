<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractPayment extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'contract_id',
        'cost_total',
        'payment_method',
        'payment_type',
        'installments',
        'due_date',
        'installments_value',
        'fine',
        'interest',
        'additional_info',
    ];
}
