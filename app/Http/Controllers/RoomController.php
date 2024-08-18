<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\RoomResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;

class RoomController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $rooms = Room::paginate(10);
            return $this->resourcePaginated(RoomResource::collection($rooms),'success',200);
        } catch (\Exception $e) {
            Log::error('Error listing rooms '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        try {
            // Validate the request data
            $data = $request->validated();  
            $room = Room::create($data);
            return $this->successResponse(new RoomResource($room),'stored successfully',200);
        } catch (\Exception $e) {
            Log::error('Error storing room '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        try {
            return $this->successResponse(new RoomResource($room),'success',200);
        } catch (\Exception $e) {
            Log::error('Error showing room '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        try {
            // Validate the request data
            $data = $request->validated();  
            $room->update(array_filter($data));
            return $this->successResponse(new RoomResource($room),'stored successfully',200);
        } catch (\Exception $e) {
            Log::error('Error updateing room '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        try {
            $room->delete();
            return $this->successResponse(null,'success',200);
        } catch (\Exception $e) {
            Log::error('Error deleting room '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }    
    }
}
