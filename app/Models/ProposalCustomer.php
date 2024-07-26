<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalCustomer extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ["proposal_id", "customer_id"];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, "proposal_id");
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, "customer_id");
    }
}
