<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contract extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'proposal_id',
        'address_id',
        'organization_id',
        'event_type_id',
        'document_number',
        'name',
        'ie',
        'im',
        'contact',
        'phone',
        'email'
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function contractPayment(): HasOne
    {
        return $this->hasOne(ContractPayment::class);
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(EventType::class, "event_type_id");
    }

    public function todoCards(): HasMany
    {
        return $this->hasMany(TodoCard::class);
    }
}
