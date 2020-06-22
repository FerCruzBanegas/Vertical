<?php

namespace App\Http\Controllers;

use App\Account;
use App\Box;
use App\Expense;
use App\Income;
use Illuminate\Http\Request;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\Account\AccountResource;
use App\Http\Resources\Account\AccountDetailResource;
use App\Http\Resources\Account\AccountCollection;
use Illuminate\Support\Facades\DB;

class AccountController extends ApiController
{
    protected $account;

	  public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function index(Request $request) 
    {
        if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $accounts = $this->account->orderBy('id', 'DESC');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            $accounts = $accounts->search($filter);
        }

    	$accounts = $accounts->paginate($rowsPerPage);
    	return new AccountCollection($accounts); 
    }

    public function getdataAccounts() 
    {
        $date_end = date('Y-m-d H:i:s');
        $box = Box::orderBy('id', 'DESC')->first();
        if ($box === null) {
           $date_ex = Expense::orderBy('id', 'ASC')->first();
           $date_in = Income::orderBy('id', 'ASC')->first();
           if ($date_ex && $date_in) {
              $date_init = ($date_ex->created_at > $date_in->created_at) ? $date_in->created_at : $date_ex->created_at;
           } else return;
           
        } else {
           $date_init = $box->created_at; 
        }

        $smallbox = DB::table('users AS u')
          ->join('small_boxes AS s', 'u.id', '=', 's.user_id')
          ->leftjoin('amounts AS a', 's.id', '=', 'a.small_box_id')
          ->select('s.id', 'u.name AS user', DB::raw('(s.start_amount + IFNULL(SUM(a.amount), 0)) AS total_amount'), 's.used_amount')
          ->where('s.state', 1)
          ->groupBy('s.id')
          ->get();

        $expense = DB::table('expenses')
          ->select('account_id', DB::raw('SUM(amount) AS amount'))
          ->where(function($query) use ($date_init, $date_end) {
            $query->where('created_at', '>=', $date_init)
                  ->where('created_at', '<=', $date_end)
                  ->whereNull('deleted_at');
            })
          ->groupBy('account_id');  


        $income = DB::table('incomes')
          ->select('account_id', DB::raw('SUM(amount) AS amount'))
          ->where(function($query) use ($date_init, $date_end) {
            $query->where('created_at', '>=', $date_init)
                  ->where('created_at', '<=', $date_end)
                  ->whereNull('deleted_at');
            })
          ->groupBy('account_id'); 


        $query = DB::table('accounts AS t1')
          ->leftJoinSub($expense, 't2', function ($join) {
              $join->on('t1.id', '=', 't2.account_id');
          })
          ->leftJoinSub($income, 't3', function ($join) {
              $join->on('t1.id', '=', 't3.account_id');
          })
          ->select('t1.id', 't1.title', 't1.current_amount', DB::raw('ROUND(COALESCE(t2.amount, 0), 2) AS expenses'), DB::raw('ROUND(COALESCE(t3.amount, 0), 2) AS incomes'), DB::raw('0 AS cash'))
          ->orderBy('t1.id')
          ->get();

        $data = [
            'accounts' => $query,
            'smallbox' => $smallbox,
            'dates' => [ 'init' => $date_init, 'end' => $date_end], 
        ];

        return $this->respond($data);
    }

    public function detail(Request $request, $id)
    {
        $account = $this->account->findOrFail($id);
        return new AccountDetailResource($account);
    }

    public function show($id)
    {
        $account = $this->account->findOrFail($id);
        return new AccountResource($account); 
    }

    public function store(AccountRequest $request)
    {
        try {
            $this->account->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(AccountRequest $request, $id)
    {
        try {
            $account = $this->account->find($id);
            $account->update($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function changeState($id)
    {
        try {
            $account = $this->account->find($id);
            if ($account->state === 1) {
              $account->update(['state' => 0]);
            } else {
              $account->update(['state' => 1]);
            }
            
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy($id)
    {
        try {
            $account = $this->account::find($id);
            $account->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }

    public function listing(Request $request) 
    {
    	  if ($request->is('api/accounts/listing')) $account = $this->account->listAccounts()->where('state', 1)->get();
		    else $account = $this->account->listAccounts()->get();
        return $this->respond($account);
    }
}
