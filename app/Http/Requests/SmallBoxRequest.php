<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\BalanceAccount;
use App\Http\Requests\Traits\UsesCustomErrorMessage;

class SmallBoxRequest extends FormRequest
{
    use UsesCustomErrorMessage;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $account = $this->input('start_amount');

        $rules = [
            'date_init' => 'required|date_format:Y-m-d H:i:s',
            'start_amount' => 'required|max:9|gt:0|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
            'account_id' => ['required', new BalanceAccount($account)],
            'user_id' => 'required|integer',
            'note' => 'nullable|min:5|max:120',
        ];

        // if($this->method() == 'PATCH' || $this->method() == 'PUT') {
        //     $rules['name'] .= ',' . $this->id;
        // }

        return $rules;
    }

    public function message()
    {
        return 'Por favor verifique los errores a continuación.';
    }
}
