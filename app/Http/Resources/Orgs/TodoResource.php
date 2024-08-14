<?php

namespace App\Http\Resources\Orgs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
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
            'owner_id' => $this->owner_id,
            'contract_id' => $this->contract_id,
            'event_type' => $this->contract->eventType->name,
            'status' => $this->status,
            'item' => new TodoItemResource($this->item),
            'contract_date' => optional($this->contract->contract_date)->format('Y-m-d'),
            'event_date' => optional($this->contract->event_date)->format('Y-m-d'),
        ];
    }
}
