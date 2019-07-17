<?php

namespace App\Http\Controllers;

use App\IncomeType;
use Illuminate\Http\Request;
use App\Http\Requests\IncomeTypeRequest;
use App\Http\Resources\IncomeType\IncomeTypeResource;
use App\Http\Resources\IncomeType\IncomeTypeCollection;

class IncomeTypeController extends ApiController
{
    private $incomeType;

    public function __construct(IncomeType $incomeType)
    {
        $this->incomeType = $incomeType;
    }

    public function index(Request $request) 
    {
    	if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $incometypes = $this->incomeType->orderBy('id', 'DESC');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            $incometypes = $incometypes->search($filter);
        }

        $incometypes = $incometypes->paginate($rowsPerPage);
    	return new IncomeTypeCollection($incometypes); 
    }

    public function show($id)
    {
        $incomeType = $this->incomeType->findOrFail($id);
        return new IncomeTypeResource($incomeType); 
    }

    public function store(IncomeTypeRequest $request)
    {
        try {
            $this->incomeType->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(IncomeTypeRequest $request, $id)
    {
        try {
            $incomeType = $this->incomeType->find($id);
            $incomeType->update($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy($id)
    {
        try {
            $incomeType = $this->incomeType::find($id);
            $incomeType->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }

    public function listing()
    {
        $incometypes = $this->incomeType->listIncomeTypes();
        return $this->respond($incometypes);
    }
}
