<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;
use App\Services\SubscriptionService;
use App\Http\Resources\SubscriptionResource;
use App\Http\Requests\Subscription\RenewSubscripeRequest;
use App\Http\Requests\Subscription\SuspendSubscripeRequest;

class SubscriptionController extends Controller
{
    use ApiResponseTrait;
      /**
     * @var SubscriptionService
     */
    protected $subscriptionService;

    /**
     *  SubscriptionController constructor
     * @param SubscriptionService $subscriptionService
     */
    public function __construct(SubscriptionService $subscriptionService){
        $this->subscriptionService = $subscriptionService;
    }
    
    /**
     * Renew a subscription.
     *
     * @param RenewSubscripeRequest $request
     * @param Subscription $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function renew(RenewSubscripeRequest $request,Subscription $subscription)
    {
        $data = $request->validated();
        // Call the service method and retrieve the updated subscription and discount
        [$updatedSubscription, $discount] = $this->subscriptionService->renewSubscription($data, $subscription);
        // Prepare the response data
        $responseData = [
            'subscription' => new SubscriptionResource($updatedSubscription),
            'discount' => $discount,
        ];
        return $this->successResponse($responseData,'renewed successfully',200);

    }

     /**
     * Suspend an ongoing subscription.
     *
     * @param SuspendSubscripeRequest $request
     * @param  Subscription $subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function suspend(SuspendSubscripeRequest $request, Subscription $subscription)
    {
        $subscription->status = 'suspend';
        $subscription->reason_of_suspension = $request->reason_of_suspension;
        $subscription->save();
        return $this->successResponse(new SubscriptionResource($subscription),'suspend successfully',200);
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription){
        try {
            $subscription->delete();
            return $this->successResponse(null,'deleted successfully',200);
        } catch (\Exception $e) {
            Log::error('Error deleting subscription '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }
    }


}
