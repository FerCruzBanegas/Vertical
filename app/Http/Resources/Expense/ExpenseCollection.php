<?php

namespace App\Http\Resources\Expense;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExpenseCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($expense){
                return [
                    'id' => $expense->id,
                    'title' => $expense->title,
                    'date' => $expense->date,
                    'amount' => $expense->amount,
                    'project' => $expense->project->name
                ];
            }),
        ];
    }
}
