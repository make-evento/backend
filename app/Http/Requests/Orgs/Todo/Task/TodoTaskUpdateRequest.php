<?php

namespace App\Http\Requests\Orgs\Todo\Task;

use Illuminate\Foundation\Http\FormRequest;

class TodoTaskUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'completed' => 'required|boolean',
        ];
    }
}
