<?php

namespace App\Http\Resources\MaterialType;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Activity\ActivityCreatedResource;
use App\Http\Resources\Activity\ActivityUpdatedResource;

class MaterialTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'created' => new ActivityCreatedResource($this->activities),
            'updated' => new ActivityUpdatedResource($this->activities)
        ];
    }
}
