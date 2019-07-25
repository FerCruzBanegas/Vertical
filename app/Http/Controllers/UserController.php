<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\User\UserResource;
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

    public function update(Request $request, $id)
    {
        try {
            $user = $this->user->find($id);
            $user->update($request->all());
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

    public function password(Request $request, $id)
    {
        try {
            $inputs = $request->all();
            $query  = User::where('id', $id);
            $user   = User::find($id);
            if (Hash::check($inputs['pass'], $user->password)) {
                if (isset($inputs['password'])) {
                    $inputs['password'] = bcrypt($inputs['password']);
                }
                $query->update(['password' => $inputs['password']]);
                return response()->json([
                    'success' => true,
                    'message' => message('MSG002'),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => message('MSG010')], 500);
        }
    }
}
