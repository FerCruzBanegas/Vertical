<?php

namespace App\Http\Resources\Amount;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Activity\ActivityCreatedResource;

class AmountResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'flag' => false,
            'created' => new ActivityCreatedResource($this->activities)
        ];
    }
}

