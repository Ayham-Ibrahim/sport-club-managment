<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\PaymentResource;
use App\Http\Requests\Payment\StorePaymentRequest;

class PaymentController extends Controller
{
    use ApiResponseTrait;
     /**
     * View and filter member payments.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Payment::query();
        if ($request->has('subscription_id')) {
            $query->where('subscription_id', $request->subscription_id);
        }

        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('payment_date', [$request->date_from, $request->date_to]);
        }
        $payments = $query->get();
        return response()->json($payments, 200);
    }

    /**
     * Create a payment for a subscription.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePaymentRequest $request)
    {
        try {
            $data = $request->validated();
            $payment = Payment::create($data);
            return $this->successResponse(new PaymentResource($payment),'payment created successfully',200);
        } catch (\Exception $e) {
            Log::error('Error storing payment '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }  
    }

}
