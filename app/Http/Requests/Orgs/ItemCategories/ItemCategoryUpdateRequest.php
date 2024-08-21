<?php

namespace App\Http\Requests\Orgs\ItemCategories;

use Illuminate\Foundation\Http\FormRequest;

class ItemCategoryUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
