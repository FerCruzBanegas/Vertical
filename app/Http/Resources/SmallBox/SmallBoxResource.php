<?php

namespace App\Http\Resources\SmallBox;

use Illuminate\Http\Resources\Json\JsonResource;

class SmallBoxResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date_init' => $this->date_init,
            'start_amount' => $this->start_amount,
            'user_id' => $this->user_id,
            'account_id' => $this->account_id,
            'note' => $this->note,
        ];
    }
}
