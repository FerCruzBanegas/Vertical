<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoxRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'box.date_init' => 'required|date_format:Y-m-d H:i:s',
            'box.date_end' => 'required|date_format:Y-m-d H:i:s',
            'box.note' => 'nullable|min:5|max:120',
        ];

        // if($this->method() == 'PATCH' || $this->method() == 'PUT') {
        //     $rules['name'] .= ',' . $this->id;
        // }

        return $rules;
    }
}
