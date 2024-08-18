<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"                  => $this->id,
            "description"         => $this->description,
            "discount_percentage" => $this->discount_percentage,
            "valid_from"          => $this->valid_from,
            "valid_to"            => $this->valid_to,
            'sport' => $this->when($this->sport, function () {
                return [
                    'name' => $this->sport->name,
                    'description' => $this->sport->description,
                ];
            }),
        ];
    }
}
