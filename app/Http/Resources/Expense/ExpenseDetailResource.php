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
            'created' => new ActivityCreatedResource($this->activities),
            'updated' => new ActivityUpdatedResource($this->activities)
        ];
    }
}
