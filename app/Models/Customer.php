<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ["name", "email", "phone", "organization_id"];

    public function organization()
    {
        return $this->belongsTo(Organization::class, "organization_id");
    }

    public function proposals()
    {
        return $this->hasMany(ProposalCustomer::class, "customer_id");
    }
}
