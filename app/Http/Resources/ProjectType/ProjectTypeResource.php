<?php

namespace App\Http\Resources\ProjectType;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Activity\ActivityResource;

class ProjectTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'activities' => new ActivityResource($this->activities),
        ];
    }
}
