<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SmallBoxRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'date_init' => 'required|date_format:Y-m-d H:i:s',
            'start_amount' => 'required|max:9|gt:0|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
            'user_id' => 'required|integer',
        ];

        // if($this->method() == 'PATCH' || $this->method() == 'PUT') {
        //     $rules['name'] .= ',' . $this->id;
        // }

        return $rules;
    }
}
