<?php

namespace App\Http\Resources\Income;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Activity\ActivityCreatedResource;
use App\Http\Resources\Activity\ActivityUpdatedResource;

class IncomeDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'payment' => $this->payment,
            'date' => $this->date,
            'note' => $this->note,
            'amount' => $this->amount,
            'income_type' => $this->income_type->name,
            'project' => $this->project->name,
            'created' => new ActivityCreatedResource($this->activities),
            'updated' => new ActivityUpdatedResource($this->activities)
        ];
    }
}
