<?php

namespace App\Http\Resources\MaterialType;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MaterialTypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($type){
                return [
                    'id' => $type->id,
                    'name' => $type->name,
                    'description' => $type->description,
                    'created' => (string) $type->created_at,
                    'materials' => $type->materials->count()
                ];
            }),
        ];
    }
}
