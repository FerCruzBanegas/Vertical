<?php

namespace App\Http\Controllers;

use App\Amount;
use Illuminate\Http\Request;
use App\Http\Requests\AmountRequest;
use App\Http\Resources\Amount\AmountResource;

class AmountController extends ApiController
{
    protected $amount;

	public function __construct(Amount $amount)
    {
        $this->amount = $amount;
    }

    public function show($id)
    {
        $amount = $this->amount->findOrFail($id);
        return new AccountResource($amount); 
    }

    public function store(AmountRequest $request)
    {
        try {
            $amount = $this->amount->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated(new AmountResource($amount));
    }

    public function destroy($id)
    {
        try {
            $amount = $this->amount->find($id);
            $amount->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }
}
