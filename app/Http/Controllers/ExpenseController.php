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
