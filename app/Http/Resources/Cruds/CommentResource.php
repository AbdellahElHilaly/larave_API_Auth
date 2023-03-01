<?php

namespace App\Http\Resources\Cruds;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'user' => $this->user->name,
            'comment' => $this->body,
        ];
    }
}
