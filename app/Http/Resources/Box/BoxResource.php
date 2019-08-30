<?php

namespace App\Http\Resources\Box;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Activity\ActivityCreatedResource;
use App\Http\Resources\Activity\ActivityUpdatedResource;

class BoxResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date_init' => $this->date_init,
            'date_end' => $this->date_end,
            'amount' => $this->amount,
            'note' => $this->note,
            'accounts' => collect($this->accounts)->transform(function($account){
                return [
                    'id' => $account->id,
                    'title' => $account->title,
                    'incomes' => $account->pivot->income,
                    'expenses' => $account->pivot->expense,
                    'cash' => $account->pivot->cash
                ];
            }),
            'created' => new ActivityCreatedResource($this->activities),
            'updated' => new ActivityUpdatedResource($this->activities)
        ]; 
    }
}
