<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Requests\BaseValidatorTrait;
class TagRequest extends FormRequest
{
    use BaseValidatorTrait;
    public function authorize()
    {
        return true;
    }


}
