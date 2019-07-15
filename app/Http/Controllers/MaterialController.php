<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;
use App\Http\Resources\Material\MaterialResource;
use App\Http\Resources\Material\MaterialDetailResource;
use App\Http\Resources\Material\MaterialCollection;

class MaterialController extends ApiController
{
    protected $material;

	public function __construct(Material $material)
    {
        $this->material = $material;
    }

    public function index(Request $request) 
    {
        if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $materials = $this->material->orderBy('id', 'DESC');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            $materials = $materials->search($filter);
        }

    	$materials = $materials->with('material_type')->paginate($rowsPerPage);
    	return new MaterialCollection($materials); 
    }

    public function detail($id)
    {
        $material = $this->material->findOrFail($id);
        return new MaterialDetailResource($material); 
    }

    public function show($id)
    {
        $material = $this->material->findOrFail($id);
        return new MaterialResource($material); 
    }

    public function store(MaterialRequest $request)
    {
        try {
            $this->material->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(MaterialRequest $request, $id)
    {
        try {
            $material = $this->material->find($id);
            $material->update($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy($id)
    {
        try {
            $material = $this->material::find($id);
            $material->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }

    public function listing()
    {
    	$materials = $this->material->listMaterials();
        return $this->respond($materials);
    }

    public function searchMaterial($name) 
    {
        $material = $this->material->search($name)->get();
        return $this->respond($material);
    }
}
