<?php

namespace App\Http\Resources\SmallBox;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Activity\ActivityCreatedResource;
use App\Http\Resources\Activity\ActivityUpdatedResource;

class SmallBoxDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date_init' => $this->date_init,
            'date_end' => $this->date_end,
            'start_amount' => $this->start_amount,
            'used_amount' => $this->used_amount,
            'account' => $this->account,
            'user' => $this->user,
            'state' => $this->state,
            'note' => $this->note,
            'amounts' => collect($this->amounts)->transform(function($amount){
                return [
                    'id' => $amount->id,
                    'amount' => $amount->amount,
                    'flag' => false,
                    'created' => new ActivityCreatedResource($amount->activities)
                ];
            }),
            'created' => new ActivityCreatedResource($this->activities),
            'updated' => new ActivityUpdatedResource($this->activities)
        ];
    }
}
