<?php

namespace App\Http\Controllers;

use App\SmallBox;
use Illuminate\Http\Request;
use App\Http\Requests\SmallBoxRequest;
use App\Http\Resources\SmallBox\SmallBoxResource;
use App\Http\Resources\SmallBox\SmallBoxDetailResource;
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

    public function getSmallBoxesActives() 
    {
        $data = DB::table('small_boxes AS s')
          ->join('users AS u', 's.user_id', '=', 'u.id')
          ->leftjoin('amounts AS a', 's.id', '=', 'a.small_box_id')
          ->select('s.id', 's.date_init', 's.start_amount', DB::raw('COALESCE(SUM(a.amount), 0) add_amount'), 'u.name')
          ->where('s.state', 1)
          ->groupBy('s.id')
          ->get();

        return $this->respond($data);
    }

    public function active($user) 
    {
        $query = $this->smallBox->getState($user);
        if ($query) {
            if ($query->state == 1) {
                return $this->respond([
                    'active' => false,
                    'account' => $query->account_id
                ]);
            }
        }

        return $this->respond([
            'active' => true,
            'message' => message('MSG014'),
        ]);
    }

    public function show($id)
    {
        $smallBox = $this->smallBox->findOrFail($id);
        return new SmallBoxResource($smallBox);
    }

    public function detail($id)
    {
        $smallBox = $this->smallBox->findOrFail($id);
        return new SmallBoxDetailResource($smallBox); 
    }

    public function getExpenseSmallBox(Request $request)
    {
        $params  = json_decode($request->data, true);

        $date_end = date('Y-m-d H:i:s');
        $smallBox = $this->smallBox->where('id', $params['id'])->first();
        if ($smallBox->state == 0) {
            $date_end = $smallBox->date_end;
        }

        $data = DB::table('expenses AS e')
          ->join('projects AS p', 'e.project_id', '=', 'p.id')
          ->select('e.title', 'e.payment', 'e.date', 'e.amount', 'p.name as project')
          ->where(function($query)  use ($params, $date_end) {
            $query->where('e.account_id', $params['account'])
                  ->where('e.user_id', $params['user'])
                  ->where('e.created_at', '>=', $params['date_init'])
                  ->where('e.created_at', '<=', $date_end)
                  ->whereNull('e.deleted_at');
            })
          ->get();

        return $this->respond($data);
    }

    public function store(SmallBoxRequest $request)
    {
        DB::beginTransaction();
        try {
            $query = $this->smallBox->getState($request->input('user_id'));
            if ($query && $query->state == 1) {
                return response()->json([
                    'message' => message('MSG013'),
                ], 422);
            }

            $smallBox = $this->smallBox->create($request->all());

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

            if ($request->input('state') == 0){
                return response()->json([
                    'message' => message('MSG015'),
                ], 422);
            }

            $smallBox->update($request->all());

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

            if (!is_null($smallBox->date_end)){
                return response()->json([
                    'msg' => message('MSG016')
                ]);
            }

            $smallBox->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }
}
