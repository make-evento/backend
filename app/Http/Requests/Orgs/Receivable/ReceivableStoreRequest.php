<?php

namespace App\Http\Requests\Orgs\Receivable;

use Illuminate\Foundation\Http\FormRequest;

class ReceivableStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'contract_id' => 'required',
            'customer_id' => 'required',
            'installments' => 'required|array',
            'installments.*.amount' => 'required|numeric',
            'installments.*.due_date' => 'required|date',
            'first_due_date' => 'required|date',
            'payment_type' => 'required|in:credit_card,boleto,pix',
        ];
    }
}
