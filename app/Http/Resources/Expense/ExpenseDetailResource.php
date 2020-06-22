<?php

namespace App\Http\Resources\Expense;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Activity\ActivityCreatedResource;
use App\Http\Resources\Activity\ActivityUpdatedResource;

class ExpenseDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'payment' => $this->payment,
            'date' => $this->date,
            'note' => $this->note,
            'amount' => $this->amount,
            'expense_type' => $this->expense_type->name,
            'project' => $this->project->name,
            'account' => $this->account->title,
            'materials' => collect($this->materials)->transform(function($material){
                return [
                    'name' => $material->name,
                    'unity' => $material->unity,
                    'quantity' => $material->pivot->quantity,
                    'price' => $material->pivot->price
                ];
            }),
            'people' => collect($this->people)->transform(function($person){
                return [
                    'name' => $person->name,
                    'surnames' => $person->surnames,
                    'phone' => $person->phone
                ];
            }),
            'created' => new ActivityCreatedResource($this->activities),
            'updated' => new ActivityUpdatedResource($this->activities)
        ];
    }
}
