<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserPasswordRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserDetailResource;
use App\Http\Resources\User\UserCollection;

class UserController extends ApiController
{
	protected $user;

	public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $users = $this->user->orderBy('id', 'DESC');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            $users = $users->search($filter);
        }

    	$users = $users->paginate($rowsPerPage);
    	return new UserCollection($users); 
    }

    public function detail(Request $request, $id)
    {
        $user = $this->user->findOrFail($id);
        return new UserDetailResource($user);
    }

    public function show($id)
    {
        $user = $this->user->findOrFail($id);
        return new UserResource($user); 
    }

    public function store(UserRequest $request)
    {
        try {
            $this->user->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = $this->user->find($id);
            $user->update($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function password(UserPasswordRequest $request, $id)
    {
        try {
            $user = $this->user->find($id);
            $user->update(['password' => $request->password]);
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy($id)
    {
        try {
            $user = $this->user::find($id);
            $user->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }
}
