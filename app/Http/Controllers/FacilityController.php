<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\FacilityResource;
use App\Http\Requests\Facility\StoreFacilityRequest;
use App\Http\Requests\Facility\UpdateFacilityRequest;

class FacilityController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $facilities = Facility::paginate(10);
            return $this->resourcePaginated(FacilityResource::collection($facilities),'success',200);
        } catch (\Exception $e) {
            Log::error('Error listing facilities '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFacilityRequest $request)
    {
        try {
            // Validate the request data
            $data = $request->validated();  
            $facility = Facility::create($data);
            return $this->successResponse(new FacilityResource($facility),'stored successfully',200);
        } catch (\Exception $e) {
            Log::error('Error stroing facility '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        try {
            return $this->successResponse(new FacilityResource($facility),'success',200);
        } catch (\Exception $e) {
            Log::error('Error showing facility '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFacilityRequest $request, Facility $facility)
    {
        try {
            // Validate the request data
            $data = $request->validated();  
            $facility->update(array_filter($data));
            return $this->successResponse(new FacilityResource($facility),'stored successfully',200);
        } catch (\Exception $e) {
            Log::error('Error updateing facility '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        try {
            $facility->delete();
            return $this->successResponse(null,'success',200);
        } catch (\Exception $e) {
            Log::error('Error deleting facility '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }    
    }
}
