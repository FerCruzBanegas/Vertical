<?php

namespace App\Http\Resources\Expense;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Activity\ActivityCreatedResource;

class LastExpenseCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($expense){
                return [
                    'title' => $expense->title,
                    'date' => $expense->date,
                    'payment' => $expense->payment,
                    'project' => $expense->project->name,
                    'amount' => $expense->amount,
                    'causer' => new ActivityCreatedResource($expense->activities),
                ];
            }),
        ];
    }
}
