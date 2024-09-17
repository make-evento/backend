<?php

namespace App\Http\Resources\Orgs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventsResource extends JsonResource
{
    public function toArray(Request $request)
    {
        $owners = $this->todoCards->map(function ($todoCard) {
            return $todoCard->owner->name;
        });

        $status = $this->getStatusFromTodoCards();

        return [
            "date" => $this->event_date->format('d/m/Y'),
            "contract_id" => $this->id,
            "progress" =>  ($this->todoCards()->where('status', 'done')->count() > 0) ? 
                            $this->todoCards->count() / $this->todoCards()->where('status', 'done')->count() * 100 : 
                            0,
            "customer" => [
                "name" => $this->proposal->customers()->first()->name,
                "email" => $this->proposal->customers()->first()->email
            ],
            "members" => [
                "name" => $owners->implode(', '),
            ],
            "event" => [
                "name" => $this->proposal->name,
                "type" => $this->eventType->name
            ],
            "status" => $status
        ];
    }

    private function getStatusFromTodoCards()
    {
        if ($this->todoCards()->where('status', 'todo')->exists()) {
            return 'TODO';
        }

        if ($this->todoCards()->where('status', 'progress')->exists()) {
            return 'WIP';
        }

        return 'DONE';
    }
}
