<?php

namespace App\Http\Resources\Orgs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $item = $this->resource;

        return [
            'name' => $item->item->name,
            'description' => $item->description,
            'customer_quantity' => $item->customer_quantity,
            'customer_days' => $item->customer_days,
            'customer_cost_per_unit' => $item->customer_cost_per_unit,
            'customer_cost_total' => $item->customer_cost_total,
            'supplier_quantity' => $item->supplier_quantity,
            'supplier_days' => $item->supplier_days,
            'supplier_cost_per_unit' => $item->supplier_cost_per_unit,
            'supplier_cost_total' => $item->supplier_cost_total,
        ];
    }
}
