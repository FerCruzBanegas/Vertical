<?php

namespace App\Http\Resources\Income;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Activity\ActivityCreatedResource;

class LastIncomeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($income){
                return [
                    'title' => $income->title,
                    'date' => $income->date,
                    'payment' => $income->payment,
                    'project' => $income->project->name,
                    'amount' => $income->amount,
                    'causer' => new ActivityCreatedResource($income->activities),
                ];
            }),
        ];
    }
}
