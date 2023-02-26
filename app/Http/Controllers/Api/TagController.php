<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Response;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Traits\ExceptionHandlerTrait;
use App\Http\Controllers\Traits\ApiResponceTrait;
class TagController extends Controller
{
    use ExceptionHandlerTrait;
    use ApiResponceTrait;


    public function index()
    {
        try {
            $tags = TagResource::collection(Tag::all());
            if ($tags->isEmpty()) {
                throw new \Exception("No tags found.", Response::HTTP_NOT_FOUND);
            }
            return $this->apiResponse($tags, Response::HTTP_OK, "Successfully retrieved " . $tags->count() . " Tags");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function store(TagRequest $request)
    {
        try {
            $data = $request->validated();
            $tag = Tag::create($data);
            return $this->apiResponse(new TagResource($tag), Response::HTTP_CREATED, "Tag created successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function show(string $id)
    {
        try {
            $category = Tag::findOrFail($id);
            return $this->apiResponse(new TagResource($category), Response::HTTP_OK, "Tag retrieved successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function update(TagRequest $request, string $id){
        try {
            $tag = Tag::findOrFail($id);
            $data = $request->validated();
            $tag->update($data);
            return $this->apiResponse(new TagResource($tag), Response::HTTP_OK, "Tag updated successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


    public function destroy(string $id)
    {
        if($id == "deleteAll") return $this->destroyAll();
        try {
            $tag = Tag::findOrFail($id);
            $tag->delete();
            return $this->apiResponse(null, Response::HTTP_NO_CONTENT, "Tag deleted successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    private function destroyAll()
    {
        try {
            if (Tag::count() == 0) {
                return $this->apiResponse(null, Response::HTTP_NOT_FOUND, "No tags found to delete");
            }

            Tag::truncate();
            return $this->apiResponse(null, Response::HTTP_NO_CONTENT, "All tags deleted successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }



}
