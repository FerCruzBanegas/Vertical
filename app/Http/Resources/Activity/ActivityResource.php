<?php

namespace App\Http\Resources\Activity;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class ActivityResource extends JsonResource
{
    private $data;
    private $user;

    public function __construct($resource)
    {
        $this->data = $resource->where('description', 'updated')->sortByDesc('created_at')->first();
        // $this->user = $user;

        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->data->id,
            'description' => $this->data->description,
            'causer' => \App\User::where('id', $this->data->causer_id)->pluck('name')->first()
        ];
    }
}
