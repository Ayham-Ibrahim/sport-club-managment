<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"             => $this->id,
            "name"           => $this->name,
            "description"    => $this->description,
            "price_per_month"=> $this->price_per_month,
            'images'         => ImageResource::collection($this->whenLoaded('images')),
            'videos'         => VideoResource::collection($this->whenLoaded('videos')),
            
        ];
    }
}
