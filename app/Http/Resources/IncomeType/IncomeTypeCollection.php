<?php

namespace App\Http\Resources\IncomeType;

use Illuminate\Http\Resources\Json\ResourceCollection;

class IncomeTypeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($type){
                return [
                    'id' => $type->id,
                    'name' => $type->name,
                    'description' => $type->description,
                    'created' => (string) $type->created_at,
                    'incomes' => $type->incomes->count()
                ];
            }),
        ];
    }
}
