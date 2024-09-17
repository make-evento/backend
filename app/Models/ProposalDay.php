<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalDay extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ["proposal_id", "date", "start", "end"];

    protected $casts = [
        "date" => "date",
        "start" => "datetime",
        "end" => "datetime"
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, "proposal_id");
    }
}
