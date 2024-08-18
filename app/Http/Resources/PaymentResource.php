<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\SubscriptionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            "amount"=> $this->amount,
            "payment_date"=> Carbon::parse($this->payment_date)->format('d-m-Y'),
            'subscription' => new SubscriptionResource($this->subscription)
        ];
    }
}
