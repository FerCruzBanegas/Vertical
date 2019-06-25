<?php

namespace App\Http\Resources\Expense;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExpenseCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function($expense){
                return [
                    'id' => $expense->id,
                    'title' => $expense->title,
                    'payment' => $expense->payment,
                    'date' => $expense->date,
                    'note' => $expense->note,
                    'amount' => $expense->amount,
                    'created' => (string) $expense->created_at,
                    'expense_type' => $expense->expense_type->name,
                    'project' => $expense->project->name,
                    'material' => $expense->materials
                ];
            }),
        ];
    }
}
