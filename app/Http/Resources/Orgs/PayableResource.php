<?php

namespace App\Http\Resources\Orgs;

use App\Models\Supplier;
use App\Models\TodoCard;
use App\Models\TodoCardPayment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            "supplier" => [
                "name" => $this->morph
                    ->recipient->supplier->nome_fantasia,
                "category" => $this->morph
                    ->recipient->supplier->categories->pluck('id')->toArray()
            ],
            "contract_id" => $this->morph->recipient->todoCard ? $this->morph->recipient->todoCard->contract_id : null,
            "amount" => $this->amount,
            "installment" => $this->installment,
            "total_installment" => $this->total_installment,
            "due_date" => $this->due_date, // Ordened By asc
            "status" => $this->status,
            "event_date" => $this->morph->recipient->todoCard ? 
                $this->morph->recipient->todoCard->contract->event_date : null,
            "payment_type" => $this->payment_type
        ];
    }
}
