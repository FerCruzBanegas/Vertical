<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\Profile\ProfileResource;
use App\Http\Resources\Profile\ProfileCollection;
use Illuminate\Support\Facades\DB;

class ProfileController extends ApiController
{
    protected $profile;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function index(Request $request)
    {
        if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $profiles = $this->profile->orderBy('id', 'DESC');

        if ($request->has('filter')) {
            $filter = $request->input('filter');
            $profiles = $profiles->search($filter);
        }

        $profiles = $profiles->paginate($rowsPerPage);
        return new ProfileCollection($profiles); 
    }

    public function show($id)
    {
        $profile = $this->profile->find($id);
        return new ProfileResource($profile); 
    }

    public function store(ProfileRequest $request)
    {
        DB::beginTransaction();
        try {
            $profile = $this->profile->create($request->all());
            $this->syncActions($profile, $request->input('action_list'));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(ProfileRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $profile = $this->profile->find($id);
            $profile->update($request->all());
            $this->syncActions($profile, $request->input('action_list'));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy($id)
    {
        try {
            $profile = $this->profile::find($id);
            $profile->users()->update(['state' => 0]);
            $profile->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }

    public function listing()
    {
        $profiles = $this->profile->listProfiles();
        return $this->respond($profiles);
    }

    private function syncActions(Profile $profile, array $actions)
    {
        $profile->actions()->sync($actions);
    }
}
