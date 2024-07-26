<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        "name",
        "details",
        "display_details",
        "is_todo",
        "category_id",
        "organization_id",
    ];

    public function category()
    {
        return $this->belongsTo(ItemCategory::class, "category_id");
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, "organization_id");
    }

    public function eventTypeItems()
    {
        return $this->hasMany(EventTypeItem::class, "item_id");
    }

    public function proposalItems()
    {
        return $this->hasMany(ProposalItem::class, "item_id");
    }
}
