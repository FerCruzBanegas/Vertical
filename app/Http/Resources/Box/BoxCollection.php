<?php

namespace App\Http\Resources\Box;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Activity\ActivityCreatedResource;

class BoxCollection extends ResourceCollection
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
                    'created' => $box->created_at,
                ];
            }),
        ];
    }
}
