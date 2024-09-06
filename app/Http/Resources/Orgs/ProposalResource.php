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
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'version' => $this->version,
            'name' => $this->name,
            'event_type_id' => $this->event_type_id,
            'people_count' => $this->people_count,
            'description' => $this->description,
            'duration' => $this->duration,
            'created_by' => $this->user()->select('id', 'name')->first(),
            'status' => $this->status,
            'total' => $this->calculateTotal($this),
            'created_at' => $this->created_at->format('d/m/Y'),
            'customers' => CustomerResource::collection($this->customers),
            'days' => ProposalDayResource::collection($this->days),
            'items' => ProposalItemResource::collection($this->items),
            'taxes' => ProposalTaxResource::collection($this->taxes),
        ];
    }

    protected function calculateTotal($proposal)
    {
        $totalItems = $proposal->items->sum(function($item) {
            return $item['cost_total'];
        });

        $totalTaxes = $proposal->taxes->sum('value');

        return floatval($totalItems - $totalTaxes);
    }

}
