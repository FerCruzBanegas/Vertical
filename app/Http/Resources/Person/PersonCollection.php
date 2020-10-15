<?php

namespace App\Http\Resources\Person;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PersonCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($person){
                return [
                    'id' => $person->id,
                    'name' => $person->name,
                    'surnames' => $person->surnames,
                    'phone' => $person->phone,
                    'position' => $person->position->description,
                    'created' => (string) $person->created_at,
                ];
            }),
        ];
    }
}
