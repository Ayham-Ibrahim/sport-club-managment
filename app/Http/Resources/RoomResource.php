<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "days_available"=> $this->days_available,
            'sport' => $this->when($this->sport, function () {
                return [
                    'name' => $this->sport->name,
                    'description' => $this->sport->description,
                ];
            }),
        ];
    }
}
