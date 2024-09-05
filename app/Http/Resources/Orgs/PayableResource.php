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
                "name" => $this->recipient->supplier->razao_social,
                "category" => $this->recipient->supplier->categories->pluck('name')->toArray(),
            ],
            "contract_id" => $this->recipient->todoCard->id,
            "amount" => $this->installmentsDetails->sum('amount'),
            "installment" => ($this->installmentsDetails()
                ->where('status', 'paid')
                ->count() + 1 ).'/'.$this->installments,
            "installments" => $this->installmentsDetails()
                ->select('amount', 'due_date', 'status')
                ->orderBy('due_date', 'asc')->get(),
            "total_installment" => $this->installments,
            "due_date" => $this->installmentsDetails()->where('status', 'pending')->orderBy('due_date', 'asc')->first()->due_date,
            "status" => $this->status,
            "event_date" => $this->recipient->todoCard->contract->event_date,
            "payment_type" => $this->payment_type
        ];
    }
}
