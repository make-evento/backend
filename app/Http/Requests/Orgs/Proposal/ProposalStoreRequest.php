<?php

namespace App\Http\Requests\Orgs\Proposal;

use Illuminate\Foundation\Http\FormRequest;

class ProposalStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'people_count' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'event_type_id' => 'required|string|exists:event_types,id',
            'customers' => 'nullable|array',
            'customers.*' => 'nullable|string|exists:customers,id',
            'duration' => 'nullable|string',
            'parent' => 'nullable|string|exists:proposals,id',
            'days' => 'required|array|min:1',
            'days.*.date' => 'required|date',
            'days.*.start_time' => 'nullable|date_format:H:i',
            'days.*.end_time' => 'nullable|date_format:H:i|after:days.*.start_time',
            'items' => 'required|array|min:0',
            'items.*.id' => 'required|string|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.description' => 'nullable|string',
            'items.*.days' => 'required|integer|min:1',
            'items.*.cost_per_unit' => 'required|numeric|min:0',
            'items.*.cost_total' => 'required|numeric|min:0',
            'taxes' => 'nullable|array',
            'taxes.*.name' => 'required_with:taxes|string',
            'taxes.*.value' => 'required_with:taxes|numeric|min:0',
        ];
    }
}
