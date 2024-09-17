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
        return [
            "id" => $this->id,
            "customer" => [
                "name" => $this->customer->name,
                "email" => $this->customer->email
            ],
            "contract_id" => $this->sender->id,
            "event" => [
                "name" => $this->sender->proposal->name,
                "date" => (!is_null($this->sender) && 
                        !is_null($this->sender->proposal) && 
                        !is_null($this->sender->proposal->days) && 
                        $this->sender->proposal->days->count() > 0) 
                        ? $this->sender->proposal->days->first()->date->format('d/m/Y')
                        : null
            ],
            "amount" => $this->installmentsDetails->sum('amount'),
            "installment" => ($this->installmentsDetails()
                ->where('status', 'paid')
                ->count() + 1 ).'/'.$this->installments,
            "installments" => $this->installmentsDetails()
                ->select('amount', 'due_date', 'status')
                ->orderBy('due_date', 'asc')->get()->map(function ($installment) {
                    return [
                        'amount' => floatval($installment->amount),  // Formatação para float
                        'due_date' => \Carbon\Carbon::parse($installment->due_date)->format('d/m/Y'), // Formatação da data
                        'status' => $installment->status,
                    ];
                }),
            "total_installment" => $this->total_installment,
            "due_date" => $this->installmentsDetails()->where('status', 'pending')->orderBy('due_date', 'asc')->first()->due_date->format('d/m/Y'),
            "status" => $this->status,
            "payment_type" => $this->payment_type
        ];
    }
}
