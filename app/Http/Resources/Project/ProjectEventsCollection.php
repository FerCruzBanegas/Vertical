<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectEventsCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function($event){
                return [
                    'id' => $event->id,
                    'type' => $event->materials ? 'expense' : 'income',
                    'title' => $event->title,
                    'date' => $event->date,
                    'amount' => $event->amount,
                    'materials' => collect($event->materials)->transform(function($material){
                        return [
                            'name' => $material->name,
                            'unity' => $material->unity,
                            'price' => $material->pivot->price
                        ];
                    })
                ];
            })
        ];
    }
}
