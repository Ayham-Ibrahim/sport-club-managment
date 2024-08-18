<?php

namespace App\Http\Controllers\Web;

use App\Models\Sport;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use App\Http\Requests\Subscription\StoreSubscriptionRequest;

class SubscriptionController extends Controller
{
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
     * Show the form for creating a new subscription.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $sports = Sport::all();
        return view('subscriptions.create_subscription', compact('sports'));
    }

    /**
     * Store a newly created subscription in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreSubscriptionRequest $request)
    {
        $data = $request->validated();
        // Create a new receiving points with the validated data
        $this->subscriptionService->createSubscription($data);
        
        return redirect()->route('subscriptions.create')->with('success', 'Subscription created successfully.please make apayment to activate your subscription');
    }
}
