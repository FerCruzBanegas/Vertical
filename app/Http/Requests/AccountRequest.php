<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|min:3|max:60|unique:accounts,title',
            'date' => 'required|date_format:Y-m-d',
            'number' => 'nullable|min:5|max:32',
            'amount' => 'required|max:15|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
            'note' => 'nullable|min:5|max:120',
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules['title'] .= ',' . $this->id;
        }

        return $rules;
    }
}
