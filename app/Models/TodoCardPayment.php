<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoCardPayment extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'todo_card_id',
        'supplier_id',
        'closed_at',
        'payment_type',
        'installment',
        'first_payment_at',
        'amount',
        'description',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
        'closed_at' => 'date',
        'first_payment_at' => 'date',
    ];

    public function todoCard()
    {
        return $this->belongsTo(TodoCard::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class, 'installmentable_id', 'todo_card_id')
                    ->where('installmentable_type', TodoCard::class);
    }
}
