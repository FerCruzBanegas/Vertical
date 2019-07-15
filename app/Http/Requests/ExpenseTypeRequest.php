<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|min:3|max:60|unique:expense_types,name',
            'description' => 'nullable|min:5|max:120',
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules['name'] .= ',' . $this->id;
        }

        return $rules;
    }
}
