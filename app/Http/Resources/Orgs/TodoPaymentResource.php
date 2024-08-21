<?php

namespace App\Http\Resources\Orgs;

use App\Models\Installment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TodoPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        // TODO: insert due_date
        // TODO: Storage::disk('r2')->url();
        return [
            'id' => $this->id,
            'installment' => $this->installments()
                ->where('status', 'paid')
                ->count() + 1 . '/' . $this->installment,
            'amount' => $this->amount,
            'due_date' => $this->installments()
                ->where('status', 'pending')
                ->first()->due_date->format('Y-m-d'),
            'status' => $this->status($this->todoCard->id),
            'payment_type' => $this->payment_type,
            'supplier' => $this->supplier->nome_fantasia,
            'attachments' => $this->attachments,
        ];
    
    }

    protected function status($installmentable_id)
    {
        $installments_paid = $this->installments()->where('status', 'paid')->count();
        if ($installments_paid === 0) {
            return 'pending';
        }
        if ($installments_paid === $this->installments->count()) {
            return 'paid';
        }
        return 'partial';
    }
}
