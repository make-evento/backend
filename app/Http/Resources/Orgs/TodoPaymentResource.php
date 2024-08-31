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
        $Payable = $this->payables->first();

        $paidCount = $Payable
            ->installmentsDetails()
            ->where('status', 'paid')
            ->count();

        $nextInstallment = $Payable
            ->installmentsDetails()
            ->where('status', 'pending')
            ->orderBy('due_date', 'asc')
            ->first();

        return [
            'id' => $this->id,
            'installment' => ($paidCount + 1) . '/' . $Payable->installments,
            'amount' => $this->amount,
            'due_date' => $nextInstallment ? date('d/m/Y', strtotime($nextInstallment->due_date)) : null,
            'status' => $this->status($Payable),
            'payment_type' => $this->payment_type,
            'supplier' => $this->supplier->nome_fantasia,
            'attachments' => $this->attachments,
        ];
    }

    protected function status($Payable)
    {
        $installments = $Payable->installmentsDetails()->count();
        $paid = $Payable->installmentsDetails()->where('status', 'paid')->count();
        $pending = $Payable->installmentsDetails()->where('status', 'pending')->count();
        $canceled = $Payable->installmentsDetails()->where('status', 'canceled')->count();

        if ($installments === $paid) {
            return 'paid';
        }

        if ($installments === $canceled) {
            return 'canceled';
        }

        if ($pending > 0) {
            return 'pending';
        }

        return 'partial';
    }
}
