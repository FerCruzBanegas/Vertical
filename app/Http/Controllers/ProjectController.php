<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Http\Resources\Project\ProjectCollection;

class ProjectController extends ApiController
{
	protected $project;

	public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function index(Request $request) 
    {
        if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $projects = $this->project->orderBy('id', 'DESC');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            $projects = $projects->where(function ($query) use ($filter) {
                $query->where('name', 'LIKE', "%" . $filter . "%");
            });
        }

    	$projects = $projects->with('project_type')->paginate($rowsPerPage);//TODO: mandar solo name en la relacion.
    	return new ProjectCollection($projects); 
    }

    public function show($id)
    {
        $project = $this->project->findOrFail($id);
        return new ProjectResource($project); 
    }

    public function store(ProjectRequest $request)
    {
        try {
        	$uuid = \Uuid::generate()->string;

            $this->project->create([
            	'uuid'            => $uuid,
                'name'            => $request->name,
                'comments'        => $request->comments,
                'start_date'      => $request->start_date,
                'project_type_id' => $request->project_type_id,
            ]);
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(ProjectRequest $request, $id)
    {
        try {
            $project = $this->project->find($id);
            $project->update([
            	'name'            => $request->name,
                'comments'        => $request->comments,
                'start_date'      => $request->start_date,
                'project_type_id' => $request->project_type_id,
            ]);
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated($project);
    }

    public function destroy($id)
    {
        try {
            $project = $this->project::find($id);
            $project->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }

    public function listing()
    {
    	$projects = $this->project->listProjects();
        return $this->respond($projects);
    }
}
