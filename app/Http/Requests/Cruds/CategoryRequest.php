<?php

namespace App\Http\Requests\Cruds;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Requests\BaseValidatorTrait;
class CategoryRequest extends FormRequest
{
    use BaseValidatorTrait;
    public function authorize()
    {
        return true;
    }


}
