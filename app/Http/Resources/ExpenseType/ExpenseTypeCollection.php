<?php

namespace App\Http\Resources\ExpenseType;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExpenseTypeCollection extends ResourceCollection
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
                    'created' => (string) $type->created_at
                ];
            }),
        ];
    }
}
