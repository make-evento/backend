<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        "name",
        "people_count",
        "description",
        "status",
        "duration",
        "event_type_id",
        "organization_id",
        "parent_id",
        "version",
    ];

    public function version(int $version)
    {
        if ($version === 1) {
            return $this;
        }

        return $this->newQuery()->where("parent_id", $this->id)->where("version", $version)->first();
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class, "event_type_id");
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, "organization_id");
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, "proposal_customers");
    }

    public function days()
    {
        return $this->hasMany(ProposalDay::class, "proposal_id");
    }

    public function items()
    {
        return $this->hasMany(ProposalItem::class, "proposal_id");
    }

    public function taxes()
    {
        return $this->hasMany(ProposalTax::class, "proposal_id");
    }
}
