<?php

namespace App\Http\Resources\SmallBox;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Activity\ActivityCreatedResource;

class SmallBoxCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($box){
                return [
                    'id' => $box->id,
                    'date_init' => $box->date_init,
                    'date_end' => $box->date_end,
                    'causer' => new ActivityCreatedResource($box->activities),
                    'start_amount' => $box->start_amount,
                ];
            }),
        ];
    }
}
