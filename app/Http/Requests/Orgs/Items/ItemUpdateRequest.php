<?php

namespace App\Http\Requests\Orgs\Items;

use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category' => 'required|string|exists:item_categories,id',
            'details' => 'nullable|string',
            'display_details' => 'required|boolean',
            'is_todo' => 'required|boolean',
        ];
    }

}
