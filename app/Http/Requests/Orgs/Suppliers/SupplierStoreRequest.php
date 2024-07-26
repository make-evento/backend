<?php

namespace App\Http\Requests\Orgs\Suppliers;

use Illuminate\Foundation\Http\FormRequest;

class SupplierStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'required|string|max:255',
            'document_type' => 'nullable|string|in:RG,CPF,CNPJ',
            'document_number' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:30',
            'address.street' => 'required|string|max:255',
            'address.number' => 'required|string|max:255',
            'address.complement' => 'nullable|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.state' => 'required|string|max:255',
            'address.zip_code' => 'required|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'required|exists:item_categories,id',
            'bank_accounts' => 'required|array',
            'bank_accounts.*.bank_name' => 'nullable|string|max:255',
            'bank_accounts.*.bank_code' => 'nullable|numeric|max:1000',
            'bank_accounts.*.agency' => 'nullable|string|max:255',
            'bank_accounts.*.account' => 'nullable|string|max:255',
            'bank_accounts.*.account_dv' => 'nullable|string|size:1',
            'bank_accounts.*.account_type' => 'nullable|string|in:CC,CP',
            'bank_accounts.*.pix_key' => 'nullable|string|max:255',
            'bank_accounts.*.pix_key_type' => 'nullable|string|in:CPF,CNPJ,PHONE,EMAIL',
            'contacts' => 'required|array',
            'contacts.*.name' => 'required|string|max:255',
            'contacts.*.email' => 'nullable|email',
            'contacts.*.phone' => 'nullable|string|max:30',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'document_type' => $this->document_type ?? 'CPF',
        ]);
    }
}
