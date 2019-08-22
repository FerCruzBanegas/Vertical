<?php

namespace App\Http\Controllers;

use App\Box;
use Illuminate\Http\Request;
use App\Http\Requests\BoxRequest;
use App\Http\Resources\Box\BoxResource;
use App\Http\Resources\Box\BoxCollection;

class BoxController extends ApiController
{
    protected $box;

	public function __construct(Box $box)
    {
        $this->box = $box;
    }

    public function index(Request $request) 
    {
        if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $boxes = $this->box->orderBy('id', 'DESC');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            $boxes = $boxes->search($filter);
        }

    	$boxes = $boxes->paginate($rowsPerPage);
    	return new BoxCollection($boxes); 
    }

    public function show($id)
    {
        $box = $this->box->findOrFail($id);
        return new BoxResource($box); 
    }

    public function store(BoxRequest $request)
    {
        try {
            $this->box->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(BoxRequest $request, $id)
    {
        try {
            $box = $this->box->find($id);
            $box->update($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy($id)
    {
        try {
            $box = $this->box::find($id);
            $box->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }
}
