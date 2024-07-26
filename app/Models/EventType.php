<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventType extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ["name", "organization_id"];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, "organization_id");
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class, "event_type_id");
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, "event_type_items", "event_type_id", "item_id");
    }
}
