<?php

namespace App\Http\Resources\Activity;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class ActivityUpdatedResource extends JsonResource
{
    private $data;
    private $items;

    public function __construct($resource)
    {
        $this->data = $resource->where('description', 'updated')->sortByDesc('created_at')->first();
        $this->items = $resource;
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        if ($this->data) {
            return [
                'id' => $this->data->id,
                'description' => $this->data->description,
                'causer' => User::where('id', $this->data->causer_id)->pluck('name')->first(),
                'date' => (string) $this->data->created_at
            ];
        }
        return new ActivityCreatedResource($this->items);
    }
}
