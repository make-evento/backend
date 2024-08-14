<?php

namespace App\Http\Requests\Orgs\Todo;

use Illuminate\Foundation\Http\FormRequest;

class TodoUpdateOwnerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'owner_id' => ['required', 'exists:users,id'],
        ];
    }
}
