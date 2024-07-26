<?php

namespace App\Http\Resources\Orgs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProposalItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'item_id' => $this->item_id,
            'name' => $this->item->name,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'days' => $this->days,
            'cost_per_unit' => $this->cost_per_unit,
            'cost_total' => $this->cost_total,
            'category' => new ItemCategoryResource($this->item->category),
        ];
    }
}
