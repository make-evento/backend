<?php

namespace App\Http\Resources\Orgs;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $owner = User::find($this->owner_id);
        return [
            'id' => $this->id,
            'owner' => [
                'id' => $owner->id,
                'name' => $owner->name, 
            ],
            'contract_id' => $this->contract_id,
            'event_type' => $this->contract->eventType->name,
            'status' => $this->status,
            'item' => new TodoItemResource($this->item),
            'contract_date' => optional($this->contract->contract_date)->format('Y-m-d'),
            'event_date' => optional($this->contract->event_date)->format('Y-m-d'),
        ];
    }
}
