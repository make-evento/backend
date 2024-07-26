<?php

namespace App\Http\Resources\Orgs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProposalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'version' => $this->version,
            'name' => $this->name,
            'event_type_id' => $this->event_type_id,
            'people_count' => $this->people_count,
            'description' => $this->description,
            'duration' => $this->duration,
            'status' => $this->status,
            'total' => 0.00,
            'created_at' => $this->created_at->format('Y-m-d'),
            'customers' => CustomerResource::collection($this->customers),
            'days' => ProposalDayResource::collection($this->days),
            'items' => ProposalItemResource::collection($this->items),
            'taxes' => ProposalTaxResource::collection($this->taxes),
        ];
    }
}
