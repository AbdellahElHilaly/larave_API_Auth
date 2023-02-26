<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\BaseValidatorTrait;
class CategoryRequest extends FormRequest
{
    use BaseValidatorTrait;
    public function authorize()
    {
        return true;
    }


}
