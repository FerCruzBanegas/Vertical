<?php

namespace App\Http\Controllers;

use App\Income;
use Illuminate\Http\Request;
use App\Http\Requests\IncomeRequest;
use App\Http\Resources\Income\IncomeResource;
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

            $incomes = $incomes->where(function ($query) use ($filter) {
                $query->where('name', 'LIKE', "%" . $filter . "%");
            });
        }

    	$incomes = $incomes->with('income_type', 'project')->paginate($rowsPerPage);//TODO: mandar solo name en la relacion.
    	return new IncomeCollection($incomes); 
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
