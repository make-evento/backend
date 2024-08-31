<?php

namespace App\Http\Resources\Orgs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceivablesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        // return $this->morph;
        return [
            "customer" => [
                "name" => $this->morph->origin->proposal->customers()->first()->name,
                "email" => $this->morph->origin->proposal->customers()->first()->email
            ],
            "contract_id" => $this->morph->origin->id,
            "event" => [
                "name" => $this->morph->origin->proposal->name,
                "date" => ($this->morph->origin->proposal->days->count() > 0) ? $this->morph->origin->proposal->days->first()->date : null
            ],
            "amount" => $this->amount,
            "installment" => $this->installment,
            "total_installment" => $this->total_installment,
            "due_date" => $this->due_date->format("Y-m-d"),
            "status" => $this->status,
            "payment_type" => $this->payment_type
        ];
    }
}
