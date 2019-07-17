<?php

namespace App\Http\Controllers;

use App\Income;
use Illuminate\Http\Request;
use App\Http\Requests\IncomeRequest;
use App\Http\Resources\Income\IncomeResource;
use App\Http\Resources\Income\IncomeDetailResource;
use App\Http\Resources\Income\IncomeCollection;

class IncomeController extends ApiController
{
    protected $income;

	public function __construct(Income $income)
    {
        $this->income = $income;
    }

    public function index(Request $request) 
    {
        if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $incomes = $this->income->orderBy('id', 'DESC');

        if ($request->has('filter')) {
            $filter = $request->input('filter');
            $incomes = $incomes->search($filter);
        }

        if ($request->has('date')) {
            $date = $request->input('date');
            $incomes = $incomes->where('date', $date);
        }

        if ($request->has('project')) {
            $project = $request->input('project');
            $incomes = $incomes->where('project_id', $project);
        }

    	$incomes = $incomes->with('income_type', 'project')->paginate($rowsPerPage);
    	return new IncomeCollection($incomes); 
    }

    public function amounts()
    {
        $mt = new \DateTime();
        $mt->modify('first day of this month');
        $month = ['first' => $mt->format('Y-m-d'), 'second' => date("Y-m-d", strtotime($mt->format('Y-m-d')."+ 1 month"))];
        $week = ['first' => date("Y-m-d", strtotime('monday this week')), 'second' => date("Y-m-d", strtotime('sunday this week'))];

        $monthlyAmount = $this->income->where(function($query) use ($month) {
            $query->where('date', '>=', $month['first'])
                  ->where('date', '<', $month['second']);
        })->sum('amount');

        $weeklyAmount = $this->income->where(function($query) use ($week) {
            $query->where('date', '>=', $week['first'])
                  ->where('date', '<', $week['second']);
        })->sum('amount');

        $dailyAmount = $this->income->where('date', date("Y-m-d"))->sum('amount');

        $data = ['month' => $monthlyAmount, 'week' => $weeklyAmount, 'day' => $dailyAmount];
        return $this->respond($data);
    }

    public function detail(Request $request, $id)
    {
        $income = $this->income->findOrFail($id);
        return new IncomeDetailResource($income);
    }

    public function show($id)
    {
        $income = $this->income->findOrFail($id);
        return new IncomeResource($income); 
    }

    public function store(IncomeRequest $request)
    {
        try {
            $this->income->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(IncomeRequest $request, $id)
    {
        try {
            $income = $this->income->find($id);
            $income->update($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy($id)
    {
        try {
            $income = $this->income::find($id);
            $income->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }
}
