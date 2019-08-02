<?php

namespace App\Http\Resources\Activity;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class ActivityCreatedResource extends JsonResource
{
    private $data;

    public function __construct($resource)
    {
        $this->data = $resource->where('description', 'created')->first();
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            'id' => $this->data->id,
            'description' => $this->data->description,
            'causer' => User::withTrashed()->where('id', $this->data->causer_id)->pluck('name')->first(),
            'date' => (string) $this->data->created_at
        ];
    }
}
