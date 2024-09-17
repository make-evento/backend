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
            "id" => $this->id,
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
                ->orderBy('due_date', 'asc')->get()
                ->map(function ($installment) {
                    return [
                        'amount' => floatval($installment->amount),  // Formatação para float
                        'due_date' => \Carbon\Carbon::parse($installment->due_date)->format('d/m/Y'), // Formatação da data
                        'status' => $installment->status,
                    ];
                }),
            "total_installment" => $this->installments,
            "due_date" => $this->installmentsDetails()->where('status', 'pending')->orderBy('due_date', 'asc')->first()->due_date->format('d/m/Y'),
            "status" => $this->status,
            "event_date" => $this->recipient->todoCard->contract->event_date->format('d/m/Y'),
            "payment_type" => $this->payment_type
        ];
    }
}
