<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;
use App\Http\Requests\PositionRequest;

class PositionController extends ApiController
{
	private $position;

    public function __construct(Position $position)
    {
        $this->position = $position;
    }

    public function store(PositionRequest $request)
    {
        try {
            $this->position->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated($request->all());
    }

    public function listing()
    {
        $positions = $this->position->listPositions();
        return $this->respond($positions);
    }
}
