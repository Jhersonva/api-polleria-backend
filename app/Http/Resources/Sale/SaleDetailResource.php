<?php

namespace App\Http\Resources\Sale;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleDetailResource extends JsonResource
{
    /**
     * Transformar el recurso en un array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sale_id' => $this->sale_id,
            'dish_id' => $this->dish_id,
            'drink_id' => $this->drink_id,
            'appetizer_id' => $this->appetizer_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'subtotal' => $this->subtotal,

            // Información del producto (si está cargada)
            'dish' => $this->whenLoaded('dish', function () {
                return [
                    'id' => $this->dish->id,
                    'name' => $this->dish->name,
                    'description' => $this->dish->description ?? null
                ];
            }),

            'drink' => $this->whenLoaded('drink', function () {
                return [
                    'id' => $this->drink->id,
                    'name' => $this->drink->name,
                    'description' => $this->drink->description ?? null
                ];
            }),

            'appetizer' => $this->whenLoaded('appetizer', function () {
                return [
                    'id' => $this->appetizer->id,
                    'name' => $this->appetizer->name
                ];
            })
        ];
    }
}
