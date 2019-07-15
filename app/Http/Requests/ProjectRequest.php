<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|min:3|max:60|unique:projects,name',
            'location' => 'required|min:5|max:100',
            'comments' => 'nullable|min:5|max:120',
            'start_date' => 'required|date_format:Y-m-d',
            'project_type_id' => 'required|integer'
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules['name'] .= ',' . $this->id;
        }

        return $rules;
    }
}
