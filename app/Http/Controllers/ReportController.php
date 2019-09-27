<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Report\InAndExMonthYearCollection;
use App\Http\Resources\Report\InAndExYearCollection;
use App\Http\Resources\Report\InAndExRangeCollection;
use App\Http\Resources\Report\InAndExMonthCollection;
use App\Http\Resources\Report\InAndExProjectCollection;
use App\Http\Resources\Report\ExDetailProjectCollection;
use App\Http\Resources\Report\ExMaterialProjectCollection;
use App\Http\Resources\Report\InAndExAccountCollection;
use App\Http\Resources\Report\ExPersonProjectCollection;
use PDF;

class ReportController extends ApiController
{
    public function getIncomeAndExpenseForDate($date = NULL) 
    {
    	  if (is_null($date)) $date = date('Y-m-d');

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


        $months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $transform = $data->transform(function($row) use ($months) {
            return [
                'month' => $months[$row->month-1],
                'expense' => $row->expenses,
                'income' => $row->incomes
            ];
        });

        return $transform;
    }

    public function getExpenseForProject() 
    {
    	  $data = DB::table('projects AS p')
          ->join('expenses AS e', 'p.id', '=', 'e.project_id')
          ->select(DB::raw('SUM(e.amount) total'), 'p.name AS project')
          ->where(function($query) {
            $query->where('e.date', '>=', DB::raw("DATE_FORMAT(NOW() ,'%Y-%m-01')"))
                  ->where('e.date', '<=', DB::raw("LAST_DAY(now())"))
                  ->where('p.state', '!=', 0)
                  ->whereNull('e.deleted_at');
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
                  ->where('i.date', '<=', DB::raw("LAST_DAY(now())"))
                  ->where('p.state', '!=', 0)
                  ->whereNull('i.deleted_at');
            })
          ->groupBy('p.name')
          ->get();

        return $data;
    }

    public function getQueryForGraphics() 
    {
      	$year = $this->getIncomeAndExpenseForDate();
      	$expense = $this->getExpenseForProject();
      	$income = $this->getIncomeForProject();

      	$data = [
      		'year' => $year,
      		'expense' => $expense,
      		'income' => $income,
      	];

      	return $this->respond($data);
    }

    public function getIncomeAndExpenseMonthYear(Request $request)
    {
      	$date = $request->data.'-01-01';
      	$data = $this->getIncomeAndExpenseForDate($date);
      	return new InAndExMonthYearCollection($data, $request->data);
    }

    public function getIncomeAndExpenseForYear()
    {
    	  $expense = DB::table('expenses')->select('date', DB::raw('0'), 'amount')->whereNull('deleted_at');;

        $data = DB::query()->fromSub(function ($query) use ($expense) {
            $query->select('date', 'amount as sale_amount', DB::raw('0 as purchase_amount'))
                  ->from('incomes')
                  ->whereNull('deleted_at')
                  ->unionAll($expense);
          }, 'sp')
          ->select(DB::raw('YEAR(date) as year'), DB::raw('SUM(sale_amount) as income'), DB::raw('SUM(purchase_amount) as expense'))
          ->groupBy(DB::raw('YEAR(date)'))
          ->get();

    	  return new InAndExYearCollection($data);
    }

    public function getIncomeAndExpenseForRange(Request $request)
    {
        if ($request->has('data')) {
        	if (sizeof($request->data) === 1) {
        		$date = [$request->data[0], $request->data[0]];
        	} else {
        		$date = $request->data;
        	}
        } else {
        	$date = [date('Y-m-d'), date('Y-m-d')];
        }
    	  $expense = DB::table('expenses as e')
                   ->select('e.title', 'e.payment', 'e.date', 'p.name', DB::raw('0 as inc_amount'), DB::raw('SUM(e.amount) as exp_amount'))
                   ->join('projects as p', 'p.id', '=', 'e.project_id')
                   ->where(function($query) use ($date) {
                    $query->where('e.date', '>=', $date[0])
                          ->where('e.date', '<=', $date[1])
                          ->whereNull('e.deleted_at');
                   })
                   ->groupBy('e.id');

        $data = DB::query()->fromSub(function ($query) use ($expense, $date) {
            $query->select('i.title', 'i.payment', 'i.date', 'p.name', DB::raw('SUM(i.amount) as inc_amount'), DB::raw('0 as exp_amount'))
                  ->from('incomes as i')
                  ->join('projects as p', 'p.id', '=', 'i.project_id')
                  ->where(function($query) use ($date) {
                    $query->where('i.date', '>=', $date[0])
                          ->where('i.date', '<=', $date[1])
                          ->whereNull('i.deleted_at');
                  })
                  ->groupBy('i.id')
                  ->unionAll($expense);
          }, 'sp')
          ->select('*')
          ->orderBy('date', 'desc')
          ->get();

    	  return new InAndExRangeCollection($data, $date);
    }

    public function getIncomeAndExpenseForMonth(Request $request)
    {
    	  $date = $request->data.'-01';

    	  $expense = DB::table('expenses as e')
                   ->select('e.title', 'e.payment', 'e.date', 'p.name', DB::raw('0 as inc_amount'), DB::raw('SUM(e.amount) as exp_amount'))
                   ->join('projects as p', 'p.id', '=', 'e.project_id')
                   ->where(function($query) use ($date) {
                    $query->where('e.date', '>=', DB::raw("DATE_FORMAT('$date' ,'%Y-%m-01')"))
                          ->where('e.date', '<=', DB::raw("LAST_DAY('$date')"))
                          ->whereNull('e.deleted_at');
                   })
                   ->groupBy('e.id');

        $data = DB::query()->fromSub(function ($query) use ($expense, $date) {
            $query->select('i.title', 'i.payment', 'i.date', 'p.name', DB::raw('SUM(i.amount) as inc_amount'), DB::raw('0 as exp_amount'))
                  ->from('incomes as i')
                  ->join('projects as p', 'p.id', '=', 'i.project_id')
                  ->where(function($query) use ($date) {
                    $query->where('i.date', '>=', DB::raw("DATE_FORMAT('$date' ,'%Y-%m-01')"))
                          ->where('i.date', '<=', DB::raw("LAST_DAY('$date')"))
                          ->whereNull('i.deleted_at');
                  })
                  ->groupBy('i.id')
                  ->unionAll($expense);
          }, 'sp')
          ->select('*')
          ->orderBy('date', 'desc')
          ->get();

    	  return new InAndExMonthCollection($data, $request->data);
    }

    public function getIncomeAndExpenseForProject(Request $request)
    {
    	  $params  = json_decode($request->data, true);
    	  $expense = DB::table('expenses as e')
                   ->select('e.title', 'e.payment', 'e.date', DB::raw('0 as inc_amount'), DB::raw('SUM(e.amount) as exp_amount'))
                   ->join('projects as p', 'p.id', '=', 'e.project_id')
                   ->where(function($query) use ($params) {
                    $query->where('p.id', '=', $params['id'])
                          ->whereNull('e.deleted_at');
                   })
                   ->groupBy('e.id');

        $data = DB::query()->fromSub(function ($query) use ($expense, $params) {
            $query->select('i.title', 'i.payment', 'i.date', DB::raw('SUM(i.amount) as inc_amount'), DB::raw('0 as exp_amount'))
                  ->from('incomes as i')
                  ->join('projects as p', 'p.id', '=', 'i.project_id')
                  ->where(function($query) use ($params) {
                    $query->where('p.id', '=', $params['id'])
                          ->whereNull('i.deleted_at');
                  })
                  ->groupBy('i.id')
                  ->unionAll($expense);
          }, 'sp')
          ->select('*')
          ->orderBy('date', 'desc')
          ->get();

    	  return new InAndExProjectCollection($data, $params['name']);
    }

    public function getExpenseDetailForProject(Request $request)
    {
    	  $params  = json_decode($request->data, true);
        $data = DB::table('projects AS p')
          ->join('expenses AS e', 'p.id', '=', 'e.project_id')
          ->join('expense_types AS t', 't.id', '=', 'e.expense_type_id')
          ->leftJoin('expense_material AS em', 'e.id', '=', 'em.expense_id')
          ->leftJoin('materials AS m', 'em.material_id', '=', 'm.id')
          ->where(function($query) use ($params) {
            $query->where('p.id', '=', $params['id'])
                  ->whereNull('e.deleted_at');
            })
          ->select('e.title', 't.name AS type', 'e.payment', 'e.date', 'm.name AS material', 'm.unity', 'em.quantity', DB::raw('COALESCE(em.price, null) AS amount'), DB::raw('COALESCE(em.quantity * em.price, e.amount) AS total'))
          ->orderBy('e.date', 'desc')
          ->get();

    	  return new ExDetailProjectCollection($data, $params['name']);
    }

    public function getExpenseMaterialForProject(Request $request)
    {
    	  $params  = json_decode($request->data, true);
        $data = DB::table('projects AS p')
          ->join('expenses AS e', 'p.id', '=', 'e.project_id')
          ->join('expense_material AS em', 'e.id', '=', 'em.expense_id')
          ->join('materials AS m', 'em.material_id', '=', 'm.id')
          ->join('material_types AS mt', 'm.material_type_id', '=', 'mt.id')
          ->where(function($query) use ($params) {
            $query->where('p.id', '=', $params['id'])
                  ->whereNull('e.deleted_at');
            })
          ->select('mt.name AS type', 'm.name', 'm.unity', DB::raw('SUM(em.quantity) AS quantity'), DB::raw('SUM(em.quantity * em.price) AS total'))
          ->groupBy('m.name', 'type', 'm.unity')
          ->get();

    	  return new ExMaterialProjectCollection($data, $params['name']);
    }

    public function getIncomeAndExpenseForAccount(Request $request)
    {
        $params  = json_decode($request->data, true);
        if (sizeof($params['range']) > 0) {
          if (sizeof($params['range']) === 1) {
            $date = [$params['range'][0], $params['range'][0]];
          } else {
            $date = $params['range'];
          }
        } else {
          $date = [date('Y-m-d'), date('Y-m-d')];
        }

        $expense = DB::table('expenses as e')
                   ->select('e.title', 'e.payment', 'e.date', DB::raw('0 as inc_amount'), DB::raw('SUM(e.amount) as exp_amount'))
                   ->join('accounts as a', 'a.id', '=', 'e.account_id')
                   ->where(function($query) use ($params, $date) {
                    $query->where('a.id', '=', $params['account']['id'])
                          ->where('e.date', '>=', $date[0])
                          ->where('e.date', '<=', $date[1])
                          ->whereNull('e.deleted_at');
                   })
                   ->groupBy('e.id');

        $data = DB::query()->fromSub(function ($query) use ($expense, $params, $date) {
            $query->select('i.title', 'i.payment', 'i.date', DB::raw('SUM(i.amount) as inc_amount'), DB::raw('0 as exp_amount'))
                  ->from('incomes as i')
                  ->join('accounts as a', 'a.id', '=', 'i.account_id')
                  ->where(function($query) use ($params, $date) {
                    $query->where('a.id', '=', $params['account']['id'])
                          ->where('i.date', '>=', $date[0])
                          ->where('i.date', '<=', $date[1])
                          ->whereNull('i.deleted_at');
                  })
                  ->groupBy('i.id')
                  ->unionAll($expense);
          }, 'sp')
          ->select('*')
          ->orderBy('date', 'desc')
          ->get();

        return new InAndExAccountCollection($data, array($params['account']['title'], $date));
    }

    public function getExpensePersonForProject(Request $request)
    {
        $params  = json_decode($request->data, true);
        $data = DB::table('projects AS p')
          ->join('expenses AS e', 'p.id', '=', 'e.project_id')
          ->join('expense_person AS ep', 'e.id', '=', 'ep.expense_id')
          ->join('people AS pe', 'ep.person_id', '=', 'pe.id')
          ->where(function($query) use ($params) {
            $query->where('p.id', '=', $params['id'])
                  ->whereNull('e.deleted_at');
            })
          ->select('e.title', 'e.date', 'pe.name', 'e.amount')
          ->get();

        return new ExPersonProjectCollection($data, $params['name']);
    }

    public function getPdfReport(Request $request) 
    {
        $date = Carbon::now();
        $totalIncome = 0;
        $totalExpense = 0;
        $totalCash = 0;
        foreach ($request->accounts as $value) {
          $totalIncome = $totalIncome + $value['incomes'];
          $totalExpense = $totalExpense + $value['expenses'];
          $totalCash = $totalCash + $value['cash'];
        }
        $array = array('accounts' => $request->accounts, 'box' => $request->box, 'totals' => [$totalIncome, $totalExpense, $totalCash], 'date' => $date->isoFormat('dddd Do MMMM, YYYY'));
        $path = public_path() . '/arqueo-caja.pdf';

        $pdf = PDF::loadView('report', $array);

        $pdf->setPaper('A4')->save($path);

        return response()->download($path);
    }
}
