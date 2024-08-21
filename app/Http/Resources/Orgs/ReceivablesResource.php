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
    public function toArray(Request $request): array
    {

        return [
            "customer" => [
                "name" => $this->contract->proposal->customers()->first()->name,
                "email" => $this->contract->proposal->customers()->first()->email
            ],
            "contract_id" => $this->contract_id,
            "event" => [
                "name" => $this->contract->proposal->name,
                "date" => $this->contract->proposal->days->first()->date
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
