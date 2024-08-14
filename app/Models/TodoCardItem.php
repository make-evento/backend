<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoCardItem extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'item_id',
        'description',
        'todo_card_id',
        'customer_quantity',
        'customer_days',
        'customer_cost_per_unit',
        'customer_cost_total',
        'supplier_quantity',
        'supplier_days',
        'supplier_cost_per_unit',
        'supplier_cost_total',
    ];

    public function todoCard()
    {
        return $this->belongsTo(TodoCard::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function supplierTotalValue()
    {
        return $this->supplier_quantity * $this->supplier_cost_per_unit * $this->supplier_days;
    }
}
