<?php

namespace App\Models;

use App\TodoCardStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoCard extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'contract_id',
        'organization_id',
        'status',
        'owner_id',
    ];

    protected $casts = [
        'status' => TodoCardStatus::class,
    ];

    public function item()
    {
        return $this->hasOne(TodoCardItem::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
