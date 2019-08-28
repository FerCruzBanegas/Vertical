<?php

namespace App\Http\Resources\Box;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Activity\ActivityCreatedResource;

class BoxResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date_init' => $this->date_init,
            'date_end' => $this->date_end,
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
            'causer' => new ActivityCreatedResource($this->activities),
        ]; 
    }
}
