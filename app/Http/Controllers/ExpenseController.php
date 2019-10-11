<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Box;
use Illuminate\Http\Request;
use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\Expense\ExpenseResource;
use App\Http\Resources\Expense\ExpenseDetailResource;
use App\Http\Resources\Expense\ExpenseCollection;
use App\Http\Resources\Expense\LastExpenseCollection;
use Illuminate\Support\Facades\DB;

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
            $expenses = $expenses->search($filter);
        }

        if ($request->has('date')) {
            $date = $request->input('date');
            $expenses = $expenses->where('date', $date);
        }

        if ($request->has('project')) {
            $project = $request->input('project');
            $expenses = $expenses->where('project_id', $project);
        }

    	$expenses = $expenses->with(['expense_type', 'project', 'materials'])->paginate($rowsPerPage);
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

    public function getLastExpense() 
    {
        $expense = $this->expense->with('project')
          ->orderBy('id', 'desc')
          ->take(5)
          ->get();

        return new LastExpenseCollection($expense);
    }


    public function detail(Request $request, $id)
    {
        $expense = $this->expense->findOrFail($id);
        return new ExpenseDetailResource($expense);
    }

    public function show($id)
    {
        $expense = $this->expense->findOrFail($id);
        return new ExpenseResource($expense); 
    }

    public function store(ExpenseRequest $request)
    {
        DB::beginTransaction();
        try {
            $expense = $this->expense->create($request->expense);
            if (!empty($request->materials)) {
                $material = array();
                foreach ($request->materials as $key => $value) {
                    $material[$value['id']] = ['quantity' => $value['quantity'], 'price' => $value['price']];
                }
                $expense->materials()->attach($material);
            } 
            if (!empty($request->people)) {
                $person = array();
                foreach ($request->people as $value) {
                    $person[] = $value['id'];
                }
                $expense->people()->attach($person);
            } 
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(ExpenseRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $expense = $this->expense->find($id);

            $box = Box::getLastBox();
            if ($box) {
                if ($expense->created_at <= $box->created_at) {
                    return response()->json([
                        'message' => message('MSG017'),
                    ], 422);
                }
            }
            
            $expense->update($request->expense);
            if (!empty($request->materials)) {
                $material = array();
                foreach ($request->materials as $key => $value) {
                    $material[$value['id']] = ['quantity' => $value['quantity'], 'price' => $value['price']];
                }
                $expense->materials()->sync($material);
            }
            if (!empty($request->people)) {
                $person = array();
                foreach ($request->people as $value) {
                    $person[] = $value['id'];
                }
                $expense->people()->sync($person);
            } 
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy($id)
    {
        try {
            $expense = $this->expense->find($id);

            $box = Box::getLastBox();
            if ($box) {
                if ($expense->created_at <= $box->created_at) {
                    return $this->respond([
                        'msg' => message('MSG017')
                    ]);
                }
            }

            $expense->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }
}
