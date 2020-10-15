<?php

namespace App\Http\Controllers;

use App\Person;
use Illuminate\Http\Request;
use App\Http\Requests\PersonRequest;
use App\Http\Resources\Person\PersonResource;
use App\Http\Resources\Person\PersonDetailResource;
use App\Http\Resources\Person\PersonCollection;

class PersonController extends ApiController
{
    private $person;

    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    public function index(Request $request) 
    {
    	if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $people = $this->person->orderBy('id', 'DESC');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            $people = $people->search($filter);
        }

        $people = $people->paginate($rowsPerPage);
    	return new PersonCollection($people); 
    }

    public function detail($id)
    {
        $person = $this->person->findOrFail($id);
        return new PersonDetailResource($person); 
    }

    public function show($id)
    {
        $person = $this->person->findOrFail($id);
        return new PersonResource($person); 
    }

    public function store(PersonRequest $request)
    {
        try {
            $this->person->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(PersonRequest $request, $id)
    {
        try {
            $person = $this->person->find($id);
            $person->update($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy($id)
    {
        try {
            $person = $this->person::find($id);
            $person->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }

    public function searchPerson($name) 
    {
        $person = $this->person->search($name)->get();
        return $this->respond($person);
    }
}
