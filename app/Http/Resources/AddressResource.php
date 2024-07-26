<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            "street" => $this->street,
            "number" => $this->number,
            "complement" => $this->complement,
            "neighborhood" => $this->neighborhood,
            "city" => $this->city,
            "state" => $this->state,
            "zip_code" => $this->zip_code,
        ];
    }
}
