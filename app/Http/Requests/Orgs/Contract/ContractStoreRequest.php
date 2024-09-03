<?php

namespace App\Http\Requests\Orgs\Contract;

use Illuminate\Foundation\Http\FormRequest;

class ContractStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer.document_number' => 'required|string',
            'customer.name' => 'required|string',
            'customer.ie' => 'nullable|string',
            'customer.im' => 'nullable|string',
            'customer.contact' => 'required|string',
            'customer.phone' => 'required|string',
            'customer.email' => 'required|string|email',
            'address.zip_code' => 'required|string',
            'address.street' => 'required|string',
            'address.number' => 'required|string',
            'address.neighborhood' => 'required|string',
            'address.city' => 'required|string',
            'address.state' => 'required|string',
            'address.complement' => 'nullable|string',
            'payment.cost_total' => 'required|numeric',
            'payment.payment_method' => 'required|string|in:full_payment,installments',
            'payment.payment_type' => 'required|string|in:pix,boleto,credit_card',
            'payment.installments' => 'required|numeric|min:1',
            'payment.due_date' => 'required|date',
            'payment.fine' => 'required|numeric',
            'payment.interest' => 'required|numeric',
            'payment.additional_info' => 'nullable|string',
            'installments' => 'required|array',
            'installments.*.due_date' => 'required|date',
            'installments.*.amount' => 'required|numeric',
            'contract_date' => 'nullable|date',
        ];
    }
}
