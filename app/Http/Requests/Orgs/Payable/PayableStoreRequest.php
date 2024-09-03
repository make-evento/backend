<?php

namespace App\Http\Requests\Orgs\Payable;

use Illuminate\Foundation\Http\FormRequest;

class PayableStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'recipient' => 'required',
            'recipient.id' => 'required|string',
            'recipient.type' => 'required|string|in:supplier',
            'amount' => 'required|numeric',
            'payment_type' => 'required|string|in:pix,boleto,credit_card',
            'status' => 'nullable|string|in:pending,paid,late',
            'installments' => 'required|array',
            'installments.*.due_date' => 'required|date',
            'installments.*.amount' => 'required|numeric'
        ];
    }
}
