<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DishCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            //'status' => $this->status,
            'image'  => $this->whenLoaded('image', function () {
                return [
                    'url' => $this->image->url,
                ];
            }),
        ];
    }
}
