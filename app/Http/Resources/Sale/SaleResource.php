<?php

namespace App\Http\Resources\Sale;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transformar el recurso en un array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'total_amount' => $this->total_amount,
            'sale_date' => $this->sale_date,
            'status' => $this->status,

            // Incluir relaciones cuando estén cargadas
            'details' => SaleDetailResource::collection($this->whenLoaded('saleDetails')),
            'payments' => SalePaymentResource::collection($this->whenLoaded('salePayments'))
        ];
    }
}
