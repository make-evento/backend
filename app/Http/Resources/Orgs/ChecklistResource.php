<?php

namespace App\Http\Resources\Orgs;

use App\Models\TodoCardItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChecklistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->proposal->parent_id === null) {
            $proposalUrl = $this->proposal_id . '/' . $this->proposal->version;
        } else {
            $proposalUrl = $this->proposal->parent_id . '/' . $this->proposal->version;
        }

        return [
            'id' => $this->id,
            'name' => $this->proposal->name,
            'customer' =>  $this->proposal->customers[0]->name,
            'date' => $this->event_date->format('Y-m-d'),
            'people_count' => $this->proposal->people_count,
            'event_type' => $this->eventType->name,
            'progress' => 0,
            'proposal_uri' => $proposalUrl,
            'todo' => $this->todoCards->map(function ($todo) {

                /** @var TodoCardItem $todoCardItem */
                $todoCardItem = $todo->item;

                return [
                    'id' => $todo->id,
                    'category' => $todoCardItem->item->category->name,
                    'item' => $todoCardItem->item->name,
                    'total_value' => $todoCardItem->supplierTotalValue(),
                    'status' => $todo->status,
                    'supplier' => '',
                    'checklist' => $todo->tasks->pluck('content'),
                    'owner' => $todo->owner->name,
                ];
            }),
        ];
    }
}
