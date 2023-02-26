<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|integer',    //|exists:categories,id
            'user_id' => 'required|integer',        //|exists:users,id
            'tags_id' => 'array',
            'tags_id.*' => 'integer|exists:tags,id',
        ];
    }

}

/*
.* for applique (required|array) to all items in array
 */
