<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\OfferResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\Offer\StoreOfferRequest;
use App\Http\Requests\Offer\UpdateOfferRequest;

class OfferController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $offers = Offer::paginate(10);
            return $this->resourcePaginated(OfferResource::collection($offers),'stored successfully',200);
        } catch (\Exception $e) {
            Log::error('Error listing offers '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfferRequest $request)
    {
        try {
            // Validate the request data
            $data = $request->validated();  
            $offer = Offer::create($data);
            return $this->successResponse(new OfferResource($offer),'stored successfully',200);
        } catch (\Exception $e) {
            Log::error('Error storing offer '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        try {
            return $this->successResponse(new OfferResource($offer),'success',200);
        } catch (\Exception $e) {
            Log::error('Error showing offer '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfferRequest $request,Offer $offer)
    {
        try {
            // Validate the request data
            $data = $request->validated();  
            $offer->update(array_filter($data));
            return $this->successResponse(new OfferResource($offer),'stored successfully',200);
        } catch (\Exception $e) {
            Log::error('Error updateing offer '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        try {
            $offer->delete();
            return $this->successResponse(null,'success',200);
        } catch (\Exception $e) {
            Log::error('Error deleting offer '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }    
    }
}
