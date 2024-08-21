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
    public function toArray(Request $request): array
    {
        return [
            "supplier" => [
            "name" => $this->todoCard
                ->payments->first()
                ->supplier->nome_fantasia,
            "category" => $this->todoCard
                ->payments->first()
                ->supplier
                ->categories->pluck('id')->toArray()
            ],
            "contract_id" => $this->todoCard->contract_id,
            "amount" => $this->amount,
            "installment" => $this->installment,
            "total_installment" => $this->total_installment,
            "due_date" => $this->due_date, // Order By
            "status" => $this->status,
            "event_date" => $this->todoCard->contract->event_date,
            "payment_type" => $this->payment_type
        ];
    }
}
