<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function($category){
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'created' => (string) $category->created_at,
                    // 'materials' => $category->materials->count()
                ];
            }),
        ];
    }
}
