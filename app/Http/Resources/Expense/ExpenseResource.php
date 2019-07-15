<?php

namespace App\Http\Resources\Expense;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'payment' => $this->payment,
            'title' => $this->title,
            'date' => $this->date,
            'note' => $this->note,
            'amount' => $this->amount,
            'expense_type_id' => $this->expense_type_id,
            'project_id' => $this->project_id
        ];        
    }
}
