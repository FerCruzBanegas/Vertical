<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpenseRequest extends FormRequest
{
    protected $payments = ['Tarjeta', 'Efectivo', 'Cheque', 'Credito', 'Transferencia'];

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|min:3|max:60',
            'payment' => ['required', Rule::in($this->payments)],
            'date' => 'required|date_format:Y-m-d',
            'note' => 'nullable|min:5|max:120',
            'amount' => 'required|max:9|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
            'expense_type_id' => 'required|integer',
            'project_id' => 'required|integer'
        ];

        // if($this->method() == 'PATCH' || $this->method() == 'PUT') {
        //     $rules['name'] .= ',' . $this->id;
        // }

        return $rules;
    }
}
