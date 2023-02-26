<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\Tag;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Traits\ExceptionHandlerTrait;
use App\Http\Controllers\Traits\ApiResponceTrait;


class ArticleController extends Controller
{
    use ExceptionHandlerTrait;
    use ApiResponceTrait;

    public function index(){
        try {
            $articles = ArticleResource::collection(Article::all());
            if ($articles->isEmpty()) {
                throw new \Exception("No articles found.", Response::HTTP_NOT_FOUND);
            }
            return $this->apiResponse($articles, Response::HTTP_OK, "Successfully retrieved " . $articles->count() . " articles");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


    public function store(ArticleRequest $request)
    {
        try {
            $data = $request->validated();
            $article = Article::create($data);

            $tags = $request->input('tags_id');
            $article->tags()->attach($tags);

            return $this->apiResponse(new ArticleResource($article), Response::HTTP_CREATED, "Article created successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


    public function show(string $id)
    {
        try {
            $article = Article::with('category', 'comments.user')->findOrFail($id);
            return $this->apiResponse(new ArticleResource($article), Response::HTTP_OK, "Article retrieved successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


    public function update(ArticleRequest $request, string $id){
        try {
            $Article = Article::findOrFail($id);
            $data = $request->validated();
            $Article->update($data);
            return $this->apiResponse(new ArticleResource($Article), Response::HTTP_OK, "Article updated successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function destroy(string $id){

        if($id == "deleteAll") return $this->destroyAll();
        try {
            $Article = Article::findOrFail($id);
            $Article->delete();
            return $this->apiResponse(null, Response::HTTP_NO_CONTENT, "Article deleted successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


    private function destroyAll()
    {
        try {
            if (Article::count() == 0) {
                return $this->apiResponse(null, Response::HTTP_NOT_FOUND, "No tags found to delete");
            }

            Article::truncate();
            return $this->apiResponse(null, Response::HTTP_NO_CONTENT, "All tags deleted successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function filter(Request $request)
    {
        $category_id = $request->get('category_id');
        $tags_id = $request->get('tags_id');

        try {
            $query = Article::query();

            if ($category_id) {
                $query->where('category_id', $category_id);
            }

            if ($tags_id) {
                $query->whereHas('tags', function ($q) use ($tags_id) {
                    $q->whereIn('id', $tags_id);
                });
            }

            $articles = $query->with('comments')->get();

            return ArticleResource::collection($articles)
                ->map(function ($article) {
                    $article->comment = $article->comment->pluck('body', 'user_id');
                    return $article;
                });
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }




}
