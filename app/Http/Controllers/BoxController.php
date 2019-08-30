<?php

namespace App\Http\Controllers;

use App\Box;
use Illuminate\Http\Request;
use App\Http\Requests\BoxRequest;
use App\Http\Resources\Box\BoxResource;
use App\Http\Resources\Box\BoxCollection;
use Illuminate\Support\Facades\DB;

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

        $filter = json_decode($request->dateRange, true);

        if (sizeof($filter) > 0) {
            $init = $filter[0].' 00:00:00';
            $end = $filter[1].' 23:59:59';

            $boxes = $boxes->where(function($query) use ($init, $end) {
                $query->where('date_init', '>=', $init)
                      ->where('date_init', '<=', $end);
            });
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
        DB::beginTransaction();
        try {
            $box = $this->box->create($request->box);
            if (!empty($request->accounts)) {
                $account = array();
                foreach ($request->accounts as $key => $value) {
                    $account[$value['id']] = ['income' => $value['incomes'], 'expense' => $value['expenses'], 'cash' => $value['cash']];
                }
                $box->accounts()->attach($account);
            } 
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(BoxRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $box = $this->box->find($id);
            $box->update($request->box);
            if (!empty($request->accounts)) {
                $account = array();
                foreach ($request->accounts as $key => $value) {
                    $account[$value['id']] = ['income' => $value['incomes'], 'expense' => $value['expenses'], 'cash' => $value['cash']];
                }
                $box->accounts()->sync($account);
            } 
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
            $box = $this->box::find($id);
            $box->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }
}
