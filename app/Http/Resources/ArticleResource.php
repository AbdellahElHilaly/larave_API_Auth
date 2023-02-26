<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user->name,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'category' => new CategoryResource($this->category),
            'comments' => CommentResource::collection($this->comments),
            'tags' => $this->tags->pluck('name'),
        ];
    }






}

