<?php

namespace App\Traits\Requests;
trait BaseValidatorTrait
{
    public function rules()
    {
        return [
            'name' => 'required|String|min:3|max:15',
            'user_id' => 'required|integer',
            'last_user_updated_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [

            'name.required' => 'The name field is required. [ status : 422 ] ' ,
            'name.string' => 'The name field must be a string. [ status : 422 ]',
            'name.min' => 'The name field must be at least :min characters. [ status : 422 ]',
            'name.max' => 'The name field may not be greater than :max characters. [ status : 422 ]',
            'user_id.required' => 'The user_id field is required. [ status : 422 ] ',
            'user_id.integer' => 'The user_id field must be an integer. [ status : 422 ]',
            'last_user_updated_id.required' => 'The last_user_updated_id field is required. [ status : 422 ] ',
            'last_user_updated_id.integer' => 'The last_user_updated_id field must be an integer. [ status : 422 ]',
        ];
    }
}



