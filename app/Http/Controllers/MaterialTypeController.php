<?php

namespace App\Http\Controllers;

use App\MaterialType;
use Illuminate\Http\Request;
use App\Http\Requests\MaterialTypeRequest;
use App\Http\Resources\MaterialType\MaterialTypeResource;
use App\Http\Resources\MaterialType\MaterialTypeCollection;

class MaterialTypeController extends ApiController
{
    private $materialType;

    public function __construct(MaterialType $materialType)
    {
        $this->materialType = $materialType;
    }

    public function index(Request $request) 
    {
    	if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $materialTypes = $this->materialType->orderBy('id', 'DESC');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            $materialTypes = $materialTypes->where(function ($query) use ($filter) {
                $query->where('name', 'LIKE', "%" . $filter . "%");
            });
        }

        $materialTypes = $materialTypes->paginate($rowsPerPage);
    	return new MaterialTypeCollection($materialTypes); 
    }

    public function show($id)
    {
        $materialType = $this->materialType->findOrFail($id);
        return new MaterialTypeResource($materialType); 
    }

    public function store(MaterialTypeRequest $request)
    {
        try {
            $this->materialType->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(MaterialTypeRequest $request, $id)
    {
        try {
            $materialType = $this->materialType->find($id);
            $materialType->update($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy($id)
    {
        try {
            $materialType = $this->materialType::find($id);
            $materialType->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }

    public function listing()
    {
    	$materialTypes = $this->materialType->listMaterialTypes();
        return $this->respond($materialTypes);
    }
}
