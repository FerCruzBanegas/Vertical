<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AccountCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($account){
                return [
                    'id' => $account->id,
                    'title' => $account->title,
                    'date' => $account->date,
                    'amount' => $account->amount,
                    'state' => $account->state === 1 ? 'Activa' : 'Inactiva',
                ];
            }),
        ];
    }
}
