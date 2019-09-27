<?php

namespace App\Http\Controllers;

use App\SmallBox;
use Illuminate\Http\Request;
use App\Http\Requests\SmallBoxRequest;
use App\Http\Resources\SmallBox\SmallBoxResource;
use App\Http\Resources\SmallBox\SmallBoxCollection;
use Illuminate\Support\Facades\DB;

class SmallBoxController extends ApiController
{
    protected $smallBox;

	public function __construct(SmallBox $smallBox)
    {
        $this->smallBox = $smallBox;
    }

    public function index(Request $request) 
    {
        if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $smallBoxes = $this->smallBox->orderBy('id', 'DESC');

        $filter = json_decode($request->dateRange, true);

        if (sizeof($filter) > 0) {
            $init = $filter[0].' 00:00:00';
            $end = $filter[1].' 23:59:59';

            $smallBoxes = $smallBoxes->where(function($query) use ($init, $end) {
                $query->where('date_init', '>=', $init)
                      ->where('date_init', '<=', $end);
            });
        }

    	$smallBoxes = $smallBoxes->paginate($rowsPerPage);
    	return new SmallBoxCollection($smallBoxes); 
    }

    public function show($id)
    {
        $smallBox = $this->smallBox->findOrFail($id);
        return new SmallBoxResource($smallBox); 
    }

    public function store(SmallBoxRequest $request)
    {
        DB::beginTransaction();
        try {
            $smallBox = $this->smallBox->create($request->all());
            // if (!empty($request->accounts)) {
            //     $account = array();
            //     foreach ($request->accounts as $key => $value) {
            //         $account[$value['id']] = ['income' => $value['incomes'], 'expense' => $value['expenses'], 'cash' => $value['cash']];
            //     }
            //     $smallBox->accounts()->attach($account);
            // } 
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(SmallBoxRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $smallBox = $this->smallBox->find($id);
            $smallBox->update($request->smallBox);
            if (!empty($request->accounts)) {
                $account = array();
                foreach ($request->accounts as $key => $value) {
                    $account[$value['id']] = ['income' => $value['incomes'], 'expense' => $value['expenses'], 'cash' => $value['cash']];
                }
                $smallBox->accounts()->sync($account);
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
            $smallBox = $this->smallBox::find($id);
            $smallBox->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }
}
