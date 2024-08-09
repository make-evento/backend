<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ["name", "slug", "owner_id"];

    public function getRouteKeyName(): string
    {
        return "slug";
    }

    public function owner()
    {
        return $this->belongsTo(User::class, "owner_id");
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, "organization_id");
    }

    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class, "organization_id");
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, "organization_id");
    }

    public function eventTypes(): HasMany
    {
        return $this->hasMany(EventType::class, "organization_id");
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class, "organization_id");
    }

    public function itemCategories(): HasMany
    {
        return $this->hasMany(ItemCategory::class, "organization_id");
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class, "organization_id");
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class, "organization_id");
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, "organization_id");
    }

    public function todoCards(): HasMany
    {
        return $this->hasMany(TodoCard::class, "organization_id");
    }
}
