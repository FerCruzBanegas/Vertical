<?php

namespace App\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class CheckSaldo implements Rule
{
    protected $param;

    public function __construct($param)
    {
        $this->param = $param;
    }

    public function passes($attribute, $value)
    {
        $user = $this->param;
        $smallBox = DB::table('small_boxes AS s')
          ->leftJoin('amounts AS a', 's.id', '=', 'a.small_box_id')
          ->select(DB::raw('(s.start_amount + IFNULL(SUM(a.amount), 0)) AS total_amount'), 's.used_amount')
          ->where(function($query) use ($user) {
            $query->where('s.user_id', $user)
                  ->where('s.state', 1);
            })
          ->groupBy('s.id') 
          ->first();

        if ($smallBox) {
            $total = $smallBox->total_amount - $smallBox->used_amount;
            return $value <= $total;
        } else {
           return true; 
        }
    }

    public function message()
    {
        return 'No tiene saldo suficiente en su caja.';
    }
}
