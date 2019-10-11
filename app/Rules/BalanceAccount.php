<?php

namespace App\Rules;

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
        $this->amount = DB::select("CALL get_balance_account({$value}, @val)");

        return $this->amount[0]->valido >= $this->param;
    }

    public function message()
    {
        return "Esta cuenta no tiene fondos suficientes, monto actual: {$this->amount[0]->valido}.";
    }
}
