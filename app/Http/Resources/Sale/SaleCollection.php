<?php

namespace App\Http\Resources\Sale;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SaleCollection extends ResourceCollection
{
    /**
     * Transformar la colección de recursos
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => SaleResource::collection($this->collection),
            'meta' => [
                'total' => $this->collection->count(),
                'total_amount' => $this->collection->sum('total_amount')
            ]
        ];
    }
}
