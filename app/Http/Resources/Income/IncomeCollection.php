<?php

namespace App\Http\Resources\Income;

use Illuminate\Http\Resources\Json\ResourceCollection;

class IncomeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($income){
                return [
                    'id' => $income->id,
                    'title' => $income->title,
                    'date' => $income->date,
                    'amount' => $income->amount,
                    'project' => $income->project->name
                ];
            }),
        ];
    }
}
