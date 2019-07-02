<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Activity\ActivityCreatedResource;
use App\Http\Resources\Activity\ActivityUpdatedResource;

class ProjectDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'comments' => $this->comments,
            'start_date' => $this->start_date,
            'project_type' => $this->project_type->name,
            // 'created' => new ActivityCreatedResource($this->activities),
            // 'updated' => new ActivityUpdatedResource($this->activities)
        ];
    }
}
