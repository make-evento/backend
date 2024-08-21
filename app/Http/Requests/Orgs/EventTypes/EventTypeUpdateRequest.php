<?php

namespace App\Http\Requests\Orgs\EventTypes;

use Illuminate\Foundation\Http\FormRequest;

class EventTypeUpdateRequest extends FormRequest
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
            'items.*' => 'required|string|exists:items,id',
        ];
    }
}
