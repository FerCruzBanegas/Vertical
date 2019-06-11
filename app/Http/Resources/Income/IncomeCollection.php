<?php

namespace App\Http\Resources\Income;

use Illuminate\Http\Resources\Json\ResourceCollection;

class IncomeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($income){
                return [
                    'id' => $income->id,
                    'title' => $income->title,
                    'date' => $income->date,
                    'note' => $income->note,
                    'amount' => $income->amount,
                    'created' => (string) $income->created_at,
                    'income_type' => $income->income_type->name,
                    'project' => $income->project->name
                ];
            }),
        ];
    }
}
