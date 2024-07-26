<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function members()
    {
        return $this->hasMany(Member::class, "organization_id");
    }

    public function invites()
    {
        return $this->hasMany(Invite::class, "organization_id");
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, "organization_id");
    }

    public function eventTypes()
    {
        return $this->hasMany(EventType::class, "organization_id");
    }

    public function items()
    {
        return $this->hasMany(Item::class, "organization_id");
    }

    public function itemCategories()
    {
        return $this->hasMany(ItemCategory::class, "organization_id");
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, "organization_id");
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class, "organization_id");
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, "organization_id");
    }

    public function todoCards()
    {
        return $this->hasMany(TodoCard::class, "organization_id");
    }
}
