<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\BalanceAccount;

class AmountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $amount = $this->input('amount');
        
        return [
            'amount' => 'required|max:15|gt:0|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
            'small_box_id' => 'required|integer',
            'account_id' => ['required', new BalanceAccount($amount)],
        ];
    }
}
