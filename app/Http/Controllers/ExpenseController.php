<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\Expense\ExpenseResource;
use App\Http\Resources\Expense\ExpenseCollection;

class ExpenseController extends ApiController
{
    protected $expense;

	public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    public function index(Request $request) 
    {
        if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $expenses = $this->expense->orderBy('id', 'DESC');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            $expenses = $expenses->where(function ($query) use ($filter) {
                $query->where('name', 'LIKE', "%" . $filter . "%");
            });
        }

    	$expenses = $expenses->with(['expense_type', 'project', 'materials'])->paginate($rowsPerPage);//TODO: mandar solo name en la relacion.
    	return new ExpenseCollection($expenses); 
    }

    public function amounts()
    {
        $mt = new \DateTime();
        $mt->modify('first day of this month');
        $month = ['first' => $mt->format('Y-m-d'), 'second' => date("Y-m-d", strtotime($mt->format('Y-m-d')."+ 1 month"))];
        $week = ['first' => date("Y-m-d", strtotime('monday this week')), 'second' => date("Y-m-d", strtotime('sunday this week'))];

        $monthlyAmount = $this->expense->where(function($query) use ($month) {
            $query->where('date', '>=', $month['first'])
                  ->where('date', '<', $month['second']);
        })->sum('amount');

        $weeklyAmount = $this->expense->where(function($query) use ($week) {
            $query->where('date', '>=', $week['first'])
                  ->where('date', '<', $week['second']);
        })->sum('amount');

        $dailyAmount = $this->expense->where('date', date("Y-m-d"))->sum('amount');

        $data = ['month' => $monthlyAmount, 'week' => $weeklyAmount, 'day' => $dailyAmount];
        return $this->respond($data);
    }

    public function show($id)
    {
        $expense = $this->expense->findOrFail($id);
        return new ExpenseResource($expense); 
    }

    public function store(ExpenseRequest $request)
    {
        try {
            $this->expense->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(ExpenseRequest $request, $id)
    {
        try {
            $expense = $this->expense->find($id);
            $expense->update($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy($id)
    {
        try {
            $expense = $this->expense::find($id);
            $expense->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }
}
