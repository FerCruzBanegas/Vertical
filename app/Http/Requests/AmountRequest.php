<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AmountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => 'required|max:9|gt:0|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
            'small_box_id' => 'required|integer'
        ];
    }
}
