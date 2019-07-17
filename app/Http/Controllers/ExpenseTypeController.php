<?php

namespace App\Http\Controllers;

use App\ExpenseType;
use Illuminate\Http\Request;
use App\Http\Requests\ExpenseTypeRequest;
use App\Http\Resources\ExpenseType\ExpenseTypeResource;
use App\Http\Resources\ExpenseType\ExpenseTypeCollection;

class ExpenseTypeController extends ApiController
{
    private $expenseType;

    public function __construct(ExpenseType $expenseType)
    {
        $this->expenseType = $expenseType;
    }

    public function index(Request $request) 
    {
    	if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $expenseTypes = $this->expenseType->orderBy('id', 'DESC');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            $expenseTypes = $expenseTypes->search($filter);
        }

        $expenseTypes = $expenseTypes->paginate($rowsPerPage);
    	return new ExpenseTypeCollection($expenseTypes); 
    }

    public function show($id)
    {
        $expenseType = $this->expenseType->findOrFail($id);
        return new ExpenseTypeResource($expenseType); 
    }

    public function store(ExpenseTypeRequest $request)
    {
        try {
            $this->expenseType->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(ExpenseTypeRequest $request, $id)
    {
        try {
            $expenseType = $this->expenseType->find($id);
            $expenseType->update($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy($id)
    {
        try {
            $expenseType = $this->expenseType::find($id);
            $expenseType->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }

    public function listing()
    {
        $expenseTypes = $this->expenseType->listExpenseTypes();
        return $this->respond($expenseTypes);
    }
}
