<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends ApiController
{
    public function getIncomeAndExpenseForYear() 
    {

        $date = date('Y-m-d');

    	$expense = DB::table('expenses')
          ->select(
            DB::raw('MONTH(date) AS month'), 
            DB::raw('SUM(amount) AS amount')
          )
          ->where(function($query) use ($date) {
            $query->where('date', '>=', DB::raw("DATE_FORMAT('$date', '%Y-01-01')"))
                  ->where('date', '<=', DB::raw("DATE_FORMAT('$date', '%Y-12-31')"))
                  ->whereNull('deleted_at');
            })
          ->groupBy('month');  


        $income = DB::table('incomes')
          ->select(
            DB::raw('MONTH(date) AS month'), 
            DB::raw('SUM(amount) AS amount')
          )
          ->where(function($query) use ($date) {
            $query->where('date', '>=', DB::raw("DATE_FORMAT('$date', '%Y-01-01')"))
                  ->where('date', '<=', DB::raw("DATE_FORMAT('$date', '%Y-12-31')"))
                  ->whereNull('deleted_at');
            })
          ->groupBy('month'); 


        $data = DB::query()->fromSub(function ($query) {
            $query->selectRaw('1 AS month UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12');
          }, 't1')
          ->leftJoinSub($expense, 't2', function ($join) {
              $join->on('t1.month', '=', 't2.month');
          })
          ->leftJoinSub($income, 't3', function ($join) {
              $join->on('t1.month', '=', 't3.month');
          })
          ->select('t1.month', DB::raw('COALESCE(t2.amount, 0) AS expenses'), DB::raw('COALESCE(t3.amount, 0) AS incomes'))
          ->orderBy('t1.month')
          ->get();


        $months = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"); 

        $transform = $data->transform(function($row) use ($months) {
            return [
                'month' => $months[$row->month-1],
                'expense' => $row->expenses,
                'income' => $row->incomes
            ];
        });

        return $data;
    }

    public function getExpenseForProject() 
    {
    	$data = DB::table('projects AS p')
          ->join('expenses AS e', 'p.id', '=', 'e.project_id')
          ->select(DB::raw('SUM(e.amount) total'), 'p.name AS project')
          ->where(function($query) {
            $query->where('e.date', '>=', DB::raw("DATE_FORMAT(NOW() ,'%Y-%m-01')"))
                  ->where('e.date', '<=', DB::raw("LAST_DAY(now())"));
            })
          ->groupBy('p.name')
          ->get();

        return $data;
    }

    public function getIncomeForProject() 
    {
    	$data = DB::table('projects AS p')
          ->join('incomes AS i', 'p.id', '=', 'i.project_id')
          ->select(DB::raw('SUM(i.amount) total'), 'p.name AS project')
          ->where(function($query) {
            $query->where('i.date', '>=', DB::raw("DATE_FORMAT(NOW() ,'%Y-%m-01')"))
                  ->where('i.date', '<=', DB::raw("LAST_DAY(now())"));
            })
          ->groupBy('p.name')
          ->get();

        return $data;
    }

    public function getQueryForGraphics() 
    {
    	$year = $this->getIncomeAndExpenseForYear();
    	$expense = $this->getExpenseForProject();
    	$income = $this->getIncomeForProject();

    	$data = [
    		'year' => $year,
    		'expense' => $expense,
    		'income' => $income,
    	];

        return $this->respond($data);
    }
}
// select SUM(e.amount) total, p.name
// from projects p
// inner join expenses e
// on p.id = e.project_id
// where e.date >= DATE_FORMAT(NOW() ,'%Y-%m-01') and e.date <= LAST_DAY(now())
// group by p.name