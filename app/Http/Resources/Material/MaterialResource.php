<?php

namespace App\Http\Resources\Material;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'unity' => $this->unity,
            'description' => $this->description,
            'price' => $this->price,
            'material_type_id' => $this->material_type_id
        ];
    }
}
