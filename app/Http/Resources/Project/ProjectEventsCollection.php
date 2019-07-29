<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectEventsCollection extends ResourceCollection
{
    private $totals;

    public function __construct($collection, $totals)
    {
        parent::__construct($collection);
        $this->collection = $collection;
        
        $this->totals = $totals;
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($event){
                return [
                    'id' => $event->id,
                    'payment' => $event->payment,
                    'type' => $event->materials ? 'expense' : 'income',
                    'title' => $event->title,
                    'date' => $event->date,
                    'amount' => $event->amount,
                    'materials' => collect($event->materials)->transform(function($material){
                        return [
                            'name' => $material->name,
                            'quantity' => $material->pivot->quantity,
                            'price' => $material->pivot->price
                        ];
                    })
                ];
            }),
            'meta' => $this->totals,
        ];
    }
}
