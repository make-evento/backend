<?php

namespace App\Http\Requests\Orgs\Todo;

use Illuminate\Foundation\Http\FormRequest;

class TodoUpdateSupplierRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "supplier_quantity" => 'required|numeric',
            "supplier_cost_per_unit" => 'required|numeric',
            "supplier_days" => 'required|numeric',
            "supplier_cost_total" => 'required|numeric',
        ];
    }
}
