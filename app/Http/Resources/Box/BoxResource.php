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
                    'current_amount' => $account->pivot->balance,
                    'cash' => $account->pivot->cash
                ];
            }),
            'small_boxes' => collect($this->small_boxes)->transform(function($smallbox){
                return [
                    'id' => $smallbox->id,
                    'user' => $smallbox->user->name,
                    'total_amount' => $smallbox->pivot->total_amount,
                    'used_amount' => $smallbox->pivot->used_amount,
                ];
            }),
            'created' => new ActivityCreatedResource($this->activities),
            'updated' => new ActivityUpdatedResource($this->activities)
        ]; 
    }
}
