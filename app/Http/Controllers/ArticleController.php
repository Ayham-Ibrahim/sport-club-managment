<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Http\Traits\ApiResponseTrait;
use Exception;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;

class ArticleController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $articles = Article::orderBy("created_at","desc")->paginate(10);
            return $this->resourcePaginated(ArticleResource::collection($articles), 'Done', 200); 
        } catch (Exception $e) {
            Log::error('Error listing articles: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        try {
            $article = Article::create($request->validated());
            return $this->resourcePaginated(new ArticleResource($article), 'stored successfully', 200); 
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
            return $this->resourcePaginated(new ArticleResource($article), 'Done', 200); 
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
            return $this->resourcePaginated(new ArticleResource($article), 'updated successfully', 200); 
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
            return $this->resourcePaginated(null, 'Deleted sucessfully', 200); 
        } catch (Exception $e) {
            Log::error('Error deleting article: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
        
    }
}
