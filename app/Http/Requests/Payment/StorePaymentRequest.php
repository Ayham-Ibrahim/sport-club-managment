<?php

namespace App\Http\Requests\Payment;

use App\Http\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    use ApiResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subscription_id' => 'required|integer|exists:subscriptions,id',
            'amount'          => 'required|numeric|min:0',
        ];
    }
}
