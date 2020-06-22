<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\CheckSaldo;
use App\Http\Requests\Traits\UsesCustomErrorMessage;

class ExpenseRequest extends FormRequest
{
    use UsesCustomErrorMessage;
    
    protected $payments = ['Tarjeta', 'Efectivo', 'Cheque', 'Credito', 'Transferencia'];

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $amount = $this->input('expense.user_id');

        $rules = [
            'expense.title' => 'required|min:3|max:60',
            'expense.payment' => ['required', Rule::in($this->payments)],
            'expense.date' => 'required|date_format:Y-m-d',
            'expense.note' => 'nullable|min:5|max:120',
            'expense.amount' => ['required', new CheckSaldo($amount)],
            'expense.expense_type_id' => 'required|integer',
            'expense.project_id' => 'required|integer',
            'expense.account_id' => 'required|integer',
            'expense.user_id' => 'required|integer'
        ];

        // if($this->method() == 'PATCH' || $this->method() == 'PUT') {
        //     $rules['name'] .= ',' . $this->id;
        // }

        return $rules;
    }

    public function attributes()
    {
        return [
            'expense.title' => 'título',
            'expense.payment' => 'pago',
            'expense.date' => 'fecha',
            'expense.note' => 'nota',
            'expense.amount' => 'monto',
            'expense.expense_type_id' => 'tipo de egreso',
            'expense.project_id' => 'proyecto',
            'expense.account_id' => 'cuenta'
        ];
    }

    public function message()
    {
        return 'Por favor verifique los errores a continuación.';
    }
}
