<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|min:3|max:60|unique:material_types,name',
            'description' => 'nullable|min:5|max:120',
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules['name'] .= ',' . $this->id;
        }

        return $rules;
    }
}
