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
        // return $this->customer;
        return [
            "customer" => [
                "name" => $this->customer->name,
                "email" => $this->customer->email
            ],
            "contract_id" => $this->sender->id,
            "event" => [
                "name" => $this->sender->proposal->name,
                "date" => ($this->sender->proposal->days->count() > 0) ? $this->morph->sender->proposal->days->first()->date : null
            ],
            "amount" => $this->installmentsDetails->sum('amount'),
            "installment" => ($this->installmentsDetails()
                ->where('status', 'paid')
                ->count() + 1 ).'/'.$this->installments,
            "installments" => $this->installmentsDetails()
                ->select('amount', 'due_date', 'status')
                ->orderBy('due_date', 'asc')->get(),
            "total_installment" => $this->total_installment,
            "due_date" => $this->installmentsDetails()->where('status', 'pending')->orderBy('due_date', 'asc')->first()->due_date,
            "status" => $this->status,
            "payment_type" => $this->payment_type
        ];
    }
}
