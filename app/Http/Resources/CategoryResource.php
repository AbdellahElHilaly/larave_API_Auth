<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    public function toArray($request)
    {
        return [

            'title' => $this->name,
            'created_by' => $this->user->name,
            'updated_by' => $this->lastUserUpdated->name,
        ];
    }
}
