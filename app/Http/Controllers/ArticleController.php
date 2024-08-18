<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\ArticleResource;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ArticleController extends Controller
{

    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
    try {
    
        $query = Article::query();
        // If a category_id is provided, filter the articles by category
        if ($request->input('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        // Paginate the results
        $articles = $query->paginate(10);
        // Return the paginated results using your ApiResponseTrait
        return $this->resourcePaginated(ArticleResource::collection($articles), 'Done', 200); 
    } catch (Exception $e) {
        Log::error('Error listing articles: ' . $e->getMessage());
        throw new Exception($this->errorResponse(null, 'There is something wrong in the server', 500));
    }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        try {
            $article = Article::create($request->validated());
            return $this->successResponse(new ArticleResource($article), 'stored successfully', 200); 
        } catch (Exception $e) {
            Log::error('Error storing article: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        try {
            return $this->successResponse(new ArticleResource($article), 'Done', 200); 
        } catch (Exception $e) {
            Log::error('Error showinging article: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request,Article $article)
    {
        try {
            $data = $request->validated();
            $article->update(array_filter($data));
            return $this->successResponse(new ArticleResource($article), 'updated successfully', 200); 
        } catch (Exception $e) {
            Log::error('Error updating article: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        try {
            $article->delete();
            return $this->successResponse(null, 'Deleted sucessfully', 200); 
        } catch (Exception $e) {
            Log::error('Error deleting article: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
        
    }
}
