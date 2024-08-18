<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Traits\ApiResponseTrait;
use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Category::all();
            return $this->successResponse(CategoryResource::collection($categories),'success',200);
        } catch (Exception $e) {
            Log::error('Error listing categories: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try {
            $category = Category::create(['name'=>$request->name]);
            return $this->successResponse(new CategoryResource($category),'category created successfully',200);
        } catch (Exception $e) {
            Log::error('Error listing categories: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        try {
            return $this->successResponse(new CategoryResource($category),'success',200);
        } catch (Exception $e) {
            Log::error('Error listing categories: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $category->update(['name'=>$request->name]);
            return $this->successResponse(new CategoryResource($category),'category updated successfully',200);
        } catch (Exception $e) {
            Log::error('Error listing categories: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return $this->successResponse(null,'delete success',200);
        } catch (Exception $e) {
            Log::error('Error listing categories: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }
}
