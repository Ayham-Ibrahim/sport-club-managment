<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use Illuminate\Http\Request;
use App\Services\SportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\SportResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\Sport\StoreSportRequest;
use App\Http\Requests\Sport\UpdateSportRequest;

class SportController extends Controller
{
    use ApiResponseTrait;
        /**
     * @var SportService
     */
    protected $sportService;

    /**
     *  SportService constructor
     * @param SportService $sportService
     */
    public function __construct(SportService $sportService){
        $this->sportService = $sportService;
    }
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        // Get all sports
        $sports= $this->sportService->listSports();

        // Return a success response with all data
        return $this->successResponse(SportResource::collection($sports),'success',200);
    }

     /**
     *  Store a newly created soprt in storage.
     *  @param StoreSportRequest $request
     *  @return JsonResponse
     */
    public function store(StoreSportRequest $request)
    {
         // Validate the request data
         $data = $request->validated();
         // Create a new sports with the validated data
         $sport= $this->sportService->createSport($data);
         // Return a success response with the created sport data
         return $this->successResponse(new SportResource($sport),'sport created successfully',200);
    }

    
    /**
     *  Display the specified sport.
     *  @param Sport $sport
     *  @return JsonResponse
     */
    public function show(Sport $sport)
    {
        try {
            return $this->successResponse(new SportResource($sport),'success',200);
        } catch (\Exception $e) {
            Log::error('Error showing sport '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }
    }

   /**
     * Update a specific userInfo.
     *
     * @param UpdateSportRequest $request
     * @param  Sport $sport
     * @return JsonResponse
     */
    public function update(UpdateSportRequest $request,Sport $sport)
    {
        // Validate the request data
        $data = $request->validated();
        // Update the sport with the validated data
        $sport = $this->sportService->updateSport($data,$sport);
        // Return a success response with the created sport data
        return $this->successResponse(new SportResource($sport),'sport updated successfully',200);
    }

    /**
     * Remove the specified sport from storage.
     *  @param Sport $sport
     *  @return JsonResponse
     */
    public function destroy(Sport $sport)
    {
        // Delete the sport by its ID
        $this->sportService->deleteSport($sport);

        // Return a success response indicating the sport was deleted
        return $this->successResponse(null,'delete successfully',200);

    }
}
