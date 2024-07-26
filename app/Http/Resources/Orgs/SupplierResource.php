<?php

namespace App\Http\Resources\Orgs;

use App\Http\Resources\AddressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "razao_social" => $this->razao_social,
            "nome_fantasia" => $this->nome_fantasia,
            "document_type" => $this->document_type,
            "document_number" => $this->document_number,
            "email" => $this->email,
            "phone" => $this->phone,
            "address" => new AddressResource($this->address),
            "categories" => ItemCategoryResource::collection($this->categories),
            "bank_accounts" => SupplierBankAccountResource::collection($this->bankAccounts),
            "contacts" => SupplierContactResource::collection($this->contacts),
        ];
    }
}
