<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Http\Resources\Project\ProjectDetailResource;
use App\Http\Resources\Project\ProjectCollection;
use App\Http\Resources\Project\ProjectEventsCollection;

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

            $projects = $projects->search($filter);
        }

    	$projects = $projects->with('project_type')->paginate($rowsPerPage);
    	return new ProjectCollection($projects); 
    }

    public function getEvents(Request $request, $id) 
    {
        if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }
        $project = $this->project->with(['expenses', 'incomes'])->findOrFail($id);
        $totals = array('totals' => ['expense' => $project->expenses->sum('amount'), 'income' => $project->incomes->sum('amount')]);

        if ($request->has('type')) {
            $type = $request->input('type');
            if ($type == 1) {
                $events = collect($project->incomes)->sortByDesc('date')->paginate($rowsPerPage);
            } else {
                $events = collect($project->expenses)->sortByDesc('date')->paginate($rowsPerPage);
            }
        } else {
            $events = collect($project->expenses)->merge($project->incomes)->sortByDesc('date')->paginate($rowsPerPage);
        }

        return new ProjectEventsCollection($events, $totals); 
    }
    
    public function detail(Request $request, $id)
    {
        $project = $this->project->findOrFail($id);
        return new ProjectDetailResource($project);
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

            $this->project->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(ProjectRequest $request, $id)
    {
        try {
            $project = $this->project->find($id);
            $project->update($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
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

    public function openProject($id)
    {
        try {
            $project = $this->project->find($id);
            $project->update([
                'end_date' => NULL,
                'state' => 1
            ]);
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respond($project);
    }

    public function finishProject($id)
    {
        try {
            $project = $this->project->find($id);
            $project->update([
                'end_date' => date('Y-m-d'),
                'state' => 0
            ]);
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respond($project);
    }

    public function listing()
    {
    	$projects = $this->project->listProjects();
        return $this->respond($projects);
    }

    public function listReport()
    {
        $projects = $this->project->orderBy('name')->select('id', 'name')->get();
        return $this->respond($projects);
    }
}
