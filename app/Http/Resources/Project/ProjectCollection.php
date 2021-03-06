<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($project){
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'state' => $project->state === 1 ? 'En ejecución' : 'Terminado',
                    'created' => (string) $project->created_at,
                    'project_type' => $project->project_type->name
                ];
            })
        ];
    }
}
