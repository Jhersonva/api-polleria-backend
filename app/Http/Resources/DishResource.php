<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DishResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
            'dish_category_id' => $this->dish_category_id,
            'status'      => $this->status,
            'image'       => $this->whenLoaded('image', function ($image) {
                return [
                    'url' => $image->url ? asset('storage/' . $image->url) : null,
                ];
            }),
        ];
    }
}
