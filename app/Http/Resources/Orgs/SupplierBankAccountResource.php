<?php

namespace App\Http\Resources\Orgs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierBankAccountResource extends JsonResource
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
            "bank_name" => $this->bank_name,
            "bank_code" => $this->bank_code,
            "agency" => $this->agency,
            "account" => $this->account,
            "account_dv" => $this->account_dv,
            "account_type" => $this->account_type,
            "pix_key" => $this->pix_key,
            "pix_key_type" => $this->pix_key_type,
        ];
    }
}
