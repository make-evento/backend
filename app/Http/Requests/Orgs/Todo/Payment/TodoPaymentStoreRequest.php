<?php

namespace App\Http\Requests\Orgs\Todo\Payment;

use Illuminate\Foundation\Http\FormRequest;

class TodoPaymentStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'closed_at' => 'required|date',
            'payment_type' => 'required|string',
            'installments' => 'required|array',
            'installments.*.amount' => 'required|numeric',
            'installments.*.due_date' => 'required|date',
            'description' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file',
        ];
    }
}
