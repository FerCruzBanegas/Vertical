<?php

namespace App\Http\Resources\Income;

use Illuminate\Http\Resources\Json\JsonResource;

class IncomeResource extends JsonResource
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
            'income_type_id' => $this->income_type_id,
            'project_id' => $this->project_id,
            'account_id' => $this->account_id
        ];
    }
}
