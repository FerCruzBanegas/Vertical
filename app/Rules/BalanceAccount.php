<?php

namespace App\Rules;

use App\Account;
use App\SmallBox;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BalanceAccount implements Rule
{
    protected $param;
    protected $amount;

    public function __construct($param)
    {
        $this->param = $param;
    }

    public function passes($attribute, $value) 
    {
        //$this->amount = DB::select("CALL get_balance_account({$value}, @val)");
        $account = Account::where('id',  $value)->first();
        $smallBox = SmallBox::where('state', 1)->sum('start_amount');
        $this->amount = $account->current_amount - $smallBox;
        return $this->amount >= $this->param;
    }

    public function message()
    {
        $amount = number_format($this->amount, 2, '.', ',');
        return "Esta cuenta no tiene fondos suficientes, monto disponible: {$amount}";
    }
}
