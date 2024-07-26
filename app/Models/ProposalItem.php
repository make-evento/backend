<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalItem extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        "proposal_id",
        "item_id",
        "quantity",
        "description",
        "days",
        "cost_per_unit",
        "cost_total",
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, "proposal_id");
    }

    public function item()
    {
        return $this->belongsTo(Item::class, "item_id");
    }
}
