<?php

namespace App\Http\Controllers;

use App\ProjectType;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectTypeRequest;
use App\Http\Resources\ProjectType\ProjectTypeResource;
use App\Http\Resources\ProjectType\ProjectTypeCollection;

class ProjectTypeController extends ApiController
{
	private $projectType;

    public function __construct(ProjectType $projectType)
    {
        $this->projectType = $projectType;
    }

    public function index(Request $request) 
    {
    	if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $projectTypes = $this->projectType->orderBy('id', 'DESC');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            $projectTypes = $projectTypes->search($filter);
        }

        $projectTypes = $projectTypes->with('projects')->paginate($rowsPerPage);
    	return new ProjectTypeCollection($projectTypes); 
    }

    public function show($id)
    {
        $projectType = $this->projectType->findOrFail($id);
        return new ProjectTypeResource($projectType); 
    }

    public function store(ProjectTypeRequest $request)
    {
        try {
            $this->projectType->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(ProjectTypeRequest $request, $id)
    {
        try {
            $projectType = $this->projectType->find($id);
            $projectType->update($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy($id)
    {
        try {
            $projectType = $this->projectType::find($id);
            $projectType->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }

    public function listing()
    {
    	$projectTypes = $this->projectType->listProjectTypes();
        return $this->respond($projectTypes);
    }
}
