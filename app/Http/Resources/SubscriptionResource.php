<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            "name"                => $this->name,
            "email"               => $this->email,
            "start_date"          => $this->start_date,
            "end_date"            => Carbon::parse($this->end_date)->format('d-m-Y'),
            "status"              => $this->status,
            "reason_of_suspension"=> $this->reason_of_suspension,
            "discount"            => $this->discount,
            'sport' => $this->when($this->sport, function () {
                return [
                    'name' => $this->sport->name,
                    'description' => $this->sport->description,
                ];
            }),
        ];
    }
}
