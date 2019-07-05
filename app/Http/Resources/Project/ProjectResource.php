<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'comments' => $this->comments,
            'start_date' => $this->start_date,
            'project_type_id' => $this->project_type_id
        ];
    }
}
