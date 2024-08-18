<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;

class TagController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tags = Tag::all();
            return $this->successResponse(TagResource::collection($tags),'success',200);
        } catch (Exception $e) {
            Log::error('Error listing tags: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        try {
            $tag = Tag::create(['name'=>$request->name]);
            return $this->successResponse(new TagResource($tag),'tag created successfully',200);
        } catch (Exception $e) {
            Log::error('Error storeing tags: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        try {
            return $this->successResponse(new TagResource($tag),'success',200);
        } catch (Exception $e) {
            Log::error('Error showing tags: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        try {
            $tag->update(['name'=>$request->name]);
            return $this->successResponse(new TagResource($tag),'tag updated successfully',200);
        } catch (Exception $e) {
            Log::error('Error updating tags: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();
            return $this->successResponse(null,'deleted successfully',200);
        } catch (Exception $e) {
            Log::error('Error deleting tags: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }
}
