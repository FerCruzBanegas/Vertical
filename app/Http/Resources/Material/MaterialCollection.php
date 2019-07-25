<?php

namespace App\Http\Resources\Material;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MaterialCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($material){
                return [
                    'id' => $material->id,
                    'name' => $material->name,
                    'unity' => $material->unity,
                    'created' => (string) $material->created_at,
                    'material_type' => $material->material_type->name
                ];
            }),
        ];
    }
}
