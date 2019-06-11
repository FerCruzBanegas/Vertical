<?php

namespace App\Http\Resources\Material;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
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
            'unity' => $this->unity,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id
        ];
    }
}
