<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|min:3|max:60',
            'date' => 'required|date_format:Y-m-d',
            'note' => 'nullable|min:5|max:120',
            'amount' => 'max:9|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
            'income_type_id' => 'required|integer',
            'project_id' => 'required|integer'
        ];

        // if($this->method() == 'PATCH' || $this->method() == 'PUT') {
        //     $rules['name'] .= ',' . $this->id;
        // }

        return $rules;
    }
}
