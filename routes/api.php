<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
//use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

//informes de projectos, estado actual, ingreso y egresos actuales


Route::get('/test', function(Request $request) {

    // $actions = \App\Action::select('title', 'name', 'id')->get();
    // $test = array(
    //         ['title' => 'Sistema', 'permissions' => array(['id' => 1, 'name' => 'Acceso Total'])],
    //         ['title' => 'Egresos', 'permissions' => array(['id' => 2, 'name' => 'Ver Lista'],['id' => 3, 'name' => 'Ver Detalle'],['id' => 4, 'name' => 'Registrar'],['id' => 5, 'name' => 'Actualizar'],['id' => 6, 'name' => 'Actualizar'])],
    //         ['title' => 'Ingresos', 'permissions' => array(['id' => 7, 'name' => 'Ver Lista'],['id' => 8, 'name' => 'Ver Detalle'],['id' => 9, 'name' => 'Registrar'],['id' => 10, 'name' => 'Actualizar'],['id' => 11, 'name' => 'Actualizar'])]
    //     );
    //     // foreach ($actions as $key => $value) {
    //     //     $data[$key]['title'] = $value->title;
    //     // }
        
    //     $data = array();
    //     $actions->each(function ($item, $key) use(&$data) {
    //         $data[$key]['title'] = $item->title;
    //     });
    //     $data = collect($data)->unique()->values()->toArray();
        // $data->each(function ($i, $key) use($actions) {
        //     $actions->each(function ($j, $key) use($i, &$transform){
        //         if ($i['title'] == $j->title) {
        //             $transform->put('permissions', ['id' => $j->id, 'name' => $j->name]);
        //         }
        //     });
        // });

        // foreach ($data as $i) {
        //     foreach ($actions as $key => $j) {
        //         if ($i['title'] == $j->title) {
        //             $data[$key]['permissions'] = ['id' => $j->id, 'name' => $j->name];
        //         }
        //     }
        // }
        // $data = $data->map(function ($item, $key) {
        //     $object['permissions'] = 'ddd';
        // }); 
        // $route = $;
        // return response()->json($route);
        // $expenses1 = DB::table('expenses')
        //     ->select(DB::raw('SUM(amount) as total_expense, MONTH(date) as month, YEAR(date) as year'))
        //     ->groupBy(DB::raw('YEAR(date) ASC, MONTH(date) ASC'))->get();

        // $expenses = DB::table('expenses')
        // ->select(DB::raw('SUM(amount) as total_expense'))
        // ->groupBy(DB::raw('YEAR(created_at) DESC, MONTH(created_at) DESC'))->get();

        // $data = DB::table('expenses')->selectRaw('month(date) as month, sum(amount) as sum')
        //     ->groupBy(DB::raw('month desc'))
        //     ->orderBy('month', 'desc')
        //     ->get();

        // $something = DB::table('expenses')->get(['id', 'created_at'])->groupBy(function($date) {
        //     return Carbon::parse($date->created_at)->format('m');
        // });

        // $orders = $users = DB::select(DB::raw('t1.month,COALESCE(t2.amount, 0) AS expenses, COALESCE(t3.amount, 0) AS incomes'))
        //              ->from()
        //              ->where('status', '<>', 1)
        //              ->groupBy('status')
        //              ->get();

        // $expenses = DB::table('expenses')
        //     ->select(DB::raw('SUM(amount) as total_expense, MONTH(date) as month, YEAR(date) as year'))
        //     ->groupBy(DB::raw('YEAR(date) ASC, MONTH(date) ASC'))->get();

        // $expense = \App\Expense::select(
        //     DB::raw('sum(amount) as sums'), 
        //     DB::raw("MONTH(date) as months")
        //   )->where(function($query) {
        //     $query->where('date', '>=', '2019-01-01')
        //           ->where('date', '<=', '2019-12-31');
        //     })
        //   ->groupBy('months')
        //   ->get();

        // $income = \App\Income::select(
        //     DB::raw('sum(amount) as sums'), 
        //     DB::raw("MONTH(date) as months")
        //   )->where(function($query) {
        //     $query->where('date', '>=', '2019-01-01')
        //           ->where('date', '<=', '2019-12-31');
        //     })
        //   ->groupBy('months')
        //   ->get();

        // $expense = \App\Expense::select(
        //     DB::raw('MONTH(date) AS month'), 
        //     DB::raw('SUM(amount) AS amount')
        //   )
        //   ->where(function($query) {
        //     $query->where('date', '>=', '2019-01-01')
        //           ->where('date', '<=', '2019-12-31');
        //     })
        //   ->groupBy('month')->get();

        

        // $expense = DB::table('expenses')
        //   ->select(
        //     DB::raw('MONTH(date) AS month'), 
        //     DB::raw('SUM(amount) AS amount')
        //   )
        //   ->where(function($query) use ($date) {
        //     $query->where('date', '>=', DB::raw("DATE_FORMAT('$date', '%Y-01-01')"))
        //           ->where('date', '<=', DB::raw("DATE_FORMAT('$date', '%Y-12-31')"))
        //           ->whereNull('deleted_at');
        //     })
        //   ->groupBy('month');  


        // $income = DB::table('incomes')
        //   ->select(
        //     DB::raw('MONTH(date) AS month'), 
        //     DB::raw('SUM(amount) AS amount')
        //   )
        //   ->where(function($query) use ($date) {
        //     $query->where('date', '>=', DB::raw("DATE_FORMAT('$date', '%Y-01-01')"))
        //           ->where('date', '<=', DB::raw("DATE_FORMAT('$date', '%Y-12-31')"))
        //           ->whereNull('deleted_at');
        //     })
        //   ->groupBy('month'); 


        // $data = DB::table('projects AS p')
        //   ->join('incomes AS i', 'p.id', '=', 'i.project_id')
        //   ->select(DB::raw('SUM(i.amount) total'), 'p.name')
        //   ->where(function($query) {
        //     $query->where('i.date', '>=', DB::raw("DATE_FORMAT(NOW() ,'%Y-%m-01')"))
        //           ->where('i.date', '<=', DB::raw("LAST_DAY(now())"));
        //     })
        //   ->groupBy('p.name')
        //   ->get();


        $expense = DB::table('expenses as e')
                   ->select('e.title', 'e.payment', 'e.date', DB::raw('0 as inc_amount'), DB::raw('SUM(e.amount) as exp_amount'))
                   ->join('accounts as a', 'a.id', '=', 'e.account_id')
                   ->where(function($query) {
                    $query->where('a.id', '=', 1)
                          ->where('e.date', '>=', '2019-08-01')
                          ->where('e.date', '<=', '2019-08-31')
                          ->whereNull('e.deleted_at');
                   })
                   ->groupBy('e.id');

        $data = DB::query()->fromSub(function ($query) use ($expense) {
            $query->select('i.title', 'i.payment', 'i.date', DB::raw('SUM(i.amount) as inc_amount'), DB::raw('0 as exp_amount'))
                  ->from('incomes as i')
                  ->join('accounts as a', 'a.id', '=', 'i.account_id')
                  ->where(function($query) {
                    $query->where('a.id', '=', 1)
                          ->where('i.date', '>=', '2019-08-01')
                          ->where('i.date', '<=', '2019-08-31')
                          ->whereNull('i.deleted_at');
                  })
                  ->groupBy('i.id')
                  ->unionAll($expense);
          }, 'sp')
          ->select('*')
          ->orderBy('date', 'desc')
          ->get();
        return response()->json($data);
        // $expense = DB::table('expenses')
        //   ->select('account_id', DB::raw('SUM(amount) AS amount'))
        //   ->where(function($query) {
        //     $query->where('created_at', '>=', '2019-06-13 20:11:44')
        //           ->where('created_at', '<=', '2019-08-21 21:11:46')
        //           ->whereNull('deleted_at');
        //     })
        //   ->groupBy('account_id');  


        // $income = DB::table('incomes')
        //   ->select('account_id', DB::raw('SUM(amount) AS amount'))
        //   ->where(function($query) {
        //     $query->where('created_at', '>=', '2019-06-11 21:07:57')
        //           ->where('created_at', '<=', '2019-08-21 21:11:46')
        //           ->whereNull('deleted_at');
        //     })
        //   ->groupBy('account_id'); 


        // $data = DB::table('accounts AS t1')
        //   ->leftJoinSub($expense, 't2', function ($join) {
        //       $join->on('t1.id', '=', 't2.account_id');
        //   })
        //   ->leftJoinSub($income, 't3', function ($join) {
        //       $join->on('t1.id', '=', 't3.account_id');
        //   })
        //   ->select('t1.title', DB::raw('COALESCE(t2.amount, 0) AS expenses'), DB::raw('COALESCE(t3.amount, 0) AS incomes'))
        //   ->orderBy('t1.title')
        //   ->get();
        // $date_end = date('Y-m-d H:i:s');
        // $filter = ['2019-08-12', '2019-08-29'];
        // $init = $filter[0].' 00:00:00';
        // $end = $filter[1].' 23:59:59';
        // echo $end;

    // $expenses = \App\Expense::with([
    //     'expense_type',
    //     'materials'
    // ])->where('project_id', '=', 35)->get();

    // $projectType = \App\Project::findOrFail(62);
    // $data =  $projectType->activities()->where('description', 'updated')->orderBy('created_at', 'desc')->first();
    // return response()->json($data);

    // $expenses = \App\Expense::where('project_id', 53)->get();
    // $incomes = \App\Income::where('project_id', 53)->get();

    // $project = \App\Project::with(['expenses', 'incomes'])->findOrFail(53);
    // $events = $project->expenses->merge($project->incomes)->sortByDesc('date')->paginate(3);
    // $mt = new DateTime();
    // $mt->modify('first day of this month');
    // $month = ['first' => $mt->format('Y-m-d'), 'second' => date("Y-m-d", strtotime($mt->format('Y-m-d')."+ 1 month"))];
    // $week = ['first' => date("Y-m-d", strtotime('monday this week')), 'second' => date("Y-m-d", strtotime('sunday this week'))];

    // $monthlyAmount = \App\Income::where(function($query) use ($month) {
    //     $query->where('date', '>=', $month['first'])
    //           ->where('date', '<', $month['second']);
    // })->sum('amount');

    // $weeklyAmount = \App\Income::where(function($query) use ($week) {
    //     $query->where('date', '>=', $week['first'])
    //           ->where('date', '<', $week['second']);
    // })->sum('amount');

    // $dailyAmount = \App\Income::where('date', date("Y-m-d"))->sum('amount');

    // $data = ['month' => $monthlyAmount, 'week' => $weeklyAmount, 'day' => $dailyAmount];

    // return response()->json($data);
    
    // $expenses = \App\Expense::orderBy('id', 'DESC');

    // $expenses = $expenses->paginate(5);
    // return new ExpenseCollection($expenses); 
});

// \DB::listen(function($query) {
//     var_dump($query->sql);
// });


Route::post('/login', 'Auth\AuthController@login');

Route::get('project-types/listing', 'ProjectTypeController@listing');
Route::get('projects/listing', 'ProjectController@listing');
Route::get('projects/list-report', 'ProjectController@listReport');
Route::get('material-types/listing', 'MaterialTypeController@listing');
Route::get('income-types/listing', 'IncomeTypeController@listing');
Route::get('expense-types/listing', 'ExpenseTypeController@listing');
Route::get('people/listing', 'PersonController@listing');
Route::get('profiles/listing', 'ProfileController@listing');
Route::get('actions/listing', 'ActionController@listing');
Route::get('accounts/listing', 'AccountController@listing');
Route::get('accounts/listing/report', 'AccountController@listing');

Route::group(['middleware' => ['auth:api', 'acl:api']], function () {
    Route::post('logout', 'Auth\AuthController@logout');

    //User yes
    Route::get('users', 'UserController@index')->name('users.index');
    Route::get('users/{id}/detail', 'UserController@detail')->name('users.show');
    Route::post('users', 'UserController@store')->name('users.create');
    Route::get('users/{id}', 'UserController@show');
    Route::put('users/{id}', 'UserController@update')->name('users.update');
    Route::put('users/{id}/password', 'UserController@password')->name('users.update');
    Route::delete('users/{id}', 'UserController@destroy')->name('users.destroy');

    //Accounts
    Route::get('accounts', 'AccountController@index')->name('accounts.index');
    Route::get('accounts/box', 'AccountController@getdataAccounts');
    Route::get('accounts/{id}/detail', 'AccountController@detail')->name('accounts.show');
    Route::post('accounts', 'AccountController@store')->name('accounts.create');
    Route::get('accounts/{id}/edit', 'AccountController@show');
    Route::put('accounts/{id}', 'AccountController@update')->name('accounts.update');
    Route::delete('accounts/{id}', 'AccountController@destroy')->name('accounts.destroy');

    //Boxes
    Route::get('boxes', 'BoxController@index')->name('boxes.index');
    Route::get('boxes/{id}', 'BoxController@show')->name('boxes.show');
    Route::post('boxes', 'BoxController@store')->name('boxes.create');
    Route::get('boxes/{id}/edit', 'BoxController@show');
    Route::put('boxes/{id}', 'BoxController@update')->name('boxes.update');
    Route::delete('boxes/{id}', 'BoxController@destroy')->name('boxes.destroy');

    //Project-Types yes
    Route::get('project-types', 'ProjectTypeController@index')->name('project-types.index');
    Route::get('project-types/{id}', 'ProjectTypeController@show')->name('project-types.show');
    Route::post('project-types', 'ProjectTypeController@store')->name('project-types.create');
    Route::get('project-types/{id}/edit', 'ProjectTypeController@show');
    Route::put('project-types/{id}', 'ProjectTypeController@update')->name('project-types.update');
    Route::delete('project-types/{id}', 'ProjectTypeController@destroy')->name('project-types.destroy');

    //Project yes
    Route::get('projects', 'ProjectController@index')->name('projects.index');
    Route::get('projects/{id}/detail', 'ProjectController@detail')->name('projects.show');
    Route::get('projects/{id}/events', 'ProjectController@getEvents')->name('projects.show');
    Route::post('projects', 'ProjectController@store')->name('projects.create');
    Route::get('projects/{id}', 'ProjectController@show');
    Route::get('projects/{id}/finish', 'ProjectController@finishProject')->name('projects.update');
    Route::put('projects/{id}', 'ProjectController@update')->name('projects.update');
    Route::delete('projects/{id}', 'ProjectController@destroy')->name('projects.destroy');

    //Material-Types yes
    Route::get('material-types', 'MaterialTypeController@index')->name('material-types.index');
    Route::get('material-types/{id}', 'MaterialTypeController@show')->name('material-types.show');
    Route::post('material-types', 'MaterialTypeController@store')->name('material-types.create');
    Route::get('material-types/{id}/edit', 'MaterialTypeController@show');
    Route::put('material-types/{id}', 'MaterialTypeController@update')->name('material-types.update');
    Route::delete('material-types/{id}', 'MaterialTypeController@destroy')->name('material-types.destroy');

    //Material yes
    Route::get('materials', 'MaterialController@index')->name('materials.index');
    Route::get('materials/{id}/detail', 'MaterialController@detail')->name('materials.show');
    Route::get('search-material/{name}', 'MaterialController@searchMaterial');
    Route::post('materials', 'MaterialController@store')->name('materials.create');
    Route::get('materials/{id}', 'MaterialController@show');
    Route::put('materials/{id}', 'MaterialController@update')->name('materials.update');
    Route::delete('materials/{id}', 'MaterialController@destroy')->name('materials.destroy');

    //Income-Types yes
    Route::get('income-types', 'IncomeTypeController@index')->name('income-types.index');
    Route::get('income-types/{id}', 'IncomeTypeController@show')->name('income-types.show');
    Route::post('income-types', 'IncomeTypeController@store')->name('income-types.create');
    Route::get('income-types/{id}/edit', 'IncomeTypeController@show');
    Route::put('income-types/{id}', 'IncomeTypeController@update')->name('income-types.update');
    Route::delete('income-types/{id}', 'IncomeTypeController@destroy')->name('income-types.destroy');

    //Income yes
    Route::get('incomes', 'IncomeController@index')->name('incomes.index');
    Route::get('incomes/{id}/detail', 'IncomeController@detail')->name('incomes.show');
    Route::get('incomes/amounts', 'IncomeController@amounts');
    Route::post('incomes', 'IncomeController@store')->name('incomes.create');
    Route::get('incomes/{id}', 'IncomeController@show');
    Route::put('incomes/{id}', 'IncomeController@update')->name('incomes.update');
    Route::delete('incomes/{id}', 'IncomeController@destroy')->name('incomes.destroy');

    //Expense-Types yes
    Route::get('expense-types', 'ExpenseTypeController@index')->name('expense-types.index');
    Route::get('expense-types/{id}', 'ExpenseTypeController@show')->name('expense-types.show');
    Route::post('expense-types', 'ExpenseTypeController@store')->name('expense-types.create');
    Route::get('expense-types/{id}/edit', 'ExpenseTypeController@show');
    Route::put('expense-types/{id}', 'ExpenseTypeController@update')->name('expense-types.update');
    Route::delete('expense-types/{id}', 'ExpenseTypeController@destroy')->name('expense-types.destroy');

    //Expense yes
    Route::get('expenses', 'ExpenseController@index')->name('expenses.index');
    Route::get('expenses/{id}/detail', 'ExpenseController@detail')->name('expenses.show');
    Route::get('expenses/amounts', 'ExpenseController@amounts');
    Route::post('expenses', 'ExpenseController@store')->name('expenses.create');
    Route::get('expenses/{id}', 'ExpenseController@show');
    Route::put('expenses/{id}', 'ExpenseController@update')->name('expenses.update');
    Route::delete('expenses/{id}', 'ExpenseController@destroy')->name('expenses.destroy');

    //People yes
    Route::get('people', 'PersonController@index')->name('people.index');
    Route::get('people/{id}', 'PersonController@show')->name('people.show');
    Route::get('search-person/{name}', 'PersonController@searchPerson');
    Route::post('people', 'PersonController@store')->name('people.create');
    Route::get('people/{id}/edit', 'PersonController@show');
    Route::put('people/{id}', 'PersonController@update')->name('people.update');
    Route::delete('people/{id}', 'PersonController@destroy')->name('people.destroy');

    //Profiles
    Route::get('profiles', 'ProfileController@index')->name('profiles.index');
    Route::get('profiles/{id}', 'ProfileController@show')->name('profiles.show');
    Route::post('profiles', 'ProfileController@store')->name('profiles.create');
    Route::put('profiles/{id}', 'ProfileController@update')->name('profiles.update');
    Route::delete('profiles/{id}', 'ProfileController@destroy')->name('profiles.destroy');

    //Graphics
    Route::get('graphics', 'ReportController@getQueryForGraphics');

    //Reports
    Route::post('pdf-report', 'ReportController@getPdfReport');
    Route::get('report-months-year', 'ReportController@getIncomeAndExpenseMonthYear');
    Route::get('report-year', 'ReportController@getIncomeAndExpenseForYear');
    Route::get('report-range', 'ReportController@getIncomeAndExpenseForRange');
    Route::get('report-month', 'ReportController@getIncomeAndExpenseForMonth');
    Route::get('report-project', 'ReportController@getIncomeAndExpenseForProject');
    Route::get('report-detail', 'ReportController@getExpenseDetailForProject');
    Route::get('report-material', 'ReportController@getExpenseMaterialForProject');
    Route::get('report-account', 'ReportController@getIncomeAndExpenseForAccount');
});

//LEER
// revisar perfil error al deslogearse desde esas pagina
// agregar las acciones de las nuevas tablas y actualizar permisos en ruta
// agregar columna total a box
// 1.- Validar que los proyectos no se puedan finalizar sin ningun evento de ingresos o egresos.
// 2.- Validar que los proeyectos finalisados no aparescan para ser seleccionados.
// 3.- validar montos en formularios de egresos
// 4.- ver permisos para actualizar contrasena de un usuario
// SELECT
//     t1.month,
//     COALESCE(t2.amount, 0) AS expenses,
//     COALESCE(t3.amount, 0) AS incomes
// FROM
// (
//     SELECT 1 AS month UNION ALL
//     SELECT 2 UNION ALL
//     SELECT 3 UNION ALL
//     SELECT 4 UNION ALL
//     SELECT 5 UNION ALL
//     SELECT 6 UNION ALL
//     SELECT 7 UNION ALL
//     SELECT 8 UNION ALL
//     SELECT 9 UNION ALL
//     SELECT 10 UNION ALL
//     SELECT 11 UNION ALL
//     SELECT 12
// ) t1
// LEFT JOIN
// (
//     SELECT MONTH(date) AS month, SUM(amount) AS amount
//     FROM expenses
//     WHERE date >= '2019-01-01' AND date <= '2019-12-31'
//     GROUP BY MONTH(date)
// ) t2
//     ON t1.month = t2.month
// LEFT JOIN
// (
//     SELECT MONTH(date) AS month, SUM(amount) AS amount
//     FROM incomes
//     WHERE date >= '2019-01-01' AND date <= '2019-12-31'
//     GROUP BY MONTH(date)
// ) t3
//     ON t1.month = t3.month
// ORDER BY
//     t1.month;
// explain select `t1`.`month`, COALESCE(t2.amount, 0) AS expenses, COALESCE(t3.amount, 0) AS incomes 
// from (
//   select 1 AS month UNION ALL 
//   SELECT 2 UNION ALL 
//   SELECT 3 UNION ALL 
//   SELECT 4 UNION ALL 
//   SELECT 5 UNION ALL 
//   SELECT 6 UNION ALL 
//   SELECT 7 UNION ALL 
//   SELECT 8 UNION ALL 
//   SELECT 9 UNION ALL 
//   SELECT 10 UNION ALL 
//   SELECT 11 UNION ALL 
//   SELECT 12
// ) as `t1` 
// left join (
//   select MONTH(date) AS month, SUM(amount) AS amount 
//   from `expenses` 
//   where (`date` >= '2019-01-01' and `date` <= '2019-12-31' and `deleted_at` is null) 
//   group by `month`
// ) as `t2` on `t1`.`month` = `t2`.`month` 
// left join (
//   select MONTH(date) AS month, SUM(amount) AS amount 
//   from `incomes` 
//   where (`date` >= '2019-01-01' and `date` <= '2019-12-31' and `deleted_at` is null) 
//   group by `month`
// ) as `t3` on `t1`.`month` = `t3`.`month` 
// order by `t1`.`month` asc
      // report1(json) {
      //   return {
      //     dataSource: {
      //       data: json
      //     },
      //     slice: {
      //       rows: [
      //         {
      //           uniqueName: "month",
      //           caption: "mes",
      //           sort: "unsorted"
      //         }
      //       ],
      //       columns: [
      //         {
      //           uniqueName: "[Measures]"
      //         }
      //       ],
      //       measures: [
      //         {
      //           uniqueName: "income",
      //           aggregation: "sum",
      //           grandTotalCaption: "Ingresos"
      //         },
      //         {
      //           uniqueName: "expense",
      //           aggregation: "sum",
      //           grandTotalCaption: "Egresos"
      //         },
      //         {
      //           uniqueName: "diff",
      //           formula: 'sum("income") - sum("expense")',
      //           caption: "Ahorro Anual"
      //         }
      //       ]
      //     },
      //     options: {
      //       grid: {
      //         title: `Ingresos / Egresos Mensual por Año ${this.params}`
      //       },
      //     }
      //   }
      // },
// select sum(sale_amount) as sales, sum(purchase_amount) as purchases
// from (
//   (
//     select amount as sale_amount, 0 as purchase_amount 
//      from expenses
//      where date >= '2019-06-01' and date <= '2019-09-01'
//   ) union all
//   (
//     select 0, amount 
//      from incomes
//      where date >= '2019-06-01' and date <= '2019-09-01' 
//   )
  
// ) sp
// select title, date, payment, amount
// from (
//   (
//     select title, date, payment, amount
//      from expenses
//      where date >= '2019-06-01' and date <= '2019-09-01'
//   ) union all
//   (
//     select title, date, payment, amount
//      from incomes
//      where date >= '2019-06-01' and date <= '2019-09-01' 
//   )
  
// ) sp
// select * 
// from (
//   (
//     select `i`.`title`, `i`.`payment`, `i`.`date`, `p`.`name`, SUM(i.amount) as inc_amount, 0 as exp_amount 
//      from `incomes` as `i` 
//      inner join `projects` as `p` 
//      on `p`.`id` = `i`.`project_id` 
//      where (`i`.`date` >= '2019-06-01' and `i`.`date` <= '2019-09-01' and `i`.`deleted_at` is null) 
//      group by `i`.`id`
//   ) union all 
//   (
//     select `e`.`title`, `e`.`payment`, `e`.`date`, `p`.`name`, 0 as inc_amount, SUM(e.amount) as exp_amount 
//      from `expenses` as `e` 
//      inner join `projects` as `p`
//      on `p`.`id` = `e`.`project_id`
//      where (`e`.`date` >= '2019-06-01' and `e`.`date` <= '2019-09-01' and `e`.`deleted_at` is null) 
//      group by `e`.`id`
//   )
// ) as `sp` 
// order by `date` desc
// select e.id, e.title, m.name
// from projects p
// inner join expenses e
// on p.id = e.project_id
// inner join expense_material em
// on e.id = em.expense_id
// inner join materials m
// on em.material_id = m.id
// where p.id = 53
// select m.name, m.unity, sum(em.quantity), sum(em.quantity * em.price)
// from projects p
// inner join expenses e
// on p.id = e.project_id
// inner join expense_material em
// on e.id = em.expense_id
// inner join materials m
// on em.material_id = m.id
// where p.id = 53
// group by m.name, m.unity
// ef7ba6f2-44cc-3e9e-aeb9-9332b6eb40b9
// 1b2eae1f-5cc3-39f5-a0bf-b4fcdbbb6500
// f550691c-2c76-3ed5-bcb2-74b53fd768c2
// cadd3c0e-741e-373f-bd9e-f12d7f34f21b
// table {
 
//   border-collapse: separate;
//   border-spacing: 0;
//   margin: 0;
//   padding: 0;
//   width: 100%;
//   table-layout: fixed;
// }
    
// th ,td {
//   border-right:none;
//   border-bottom: 2px solid #ddd;
//   background-color: #f8f8f8;
//   padding: .35em;
// }

// #tr1 th:last-child {
//     border-top: 2px solid #ddd;
// }

// #tr1 th:nth-child(2) {
//   border-left: 2px solid #ddd;
//   border-top: 2px solid #ddd;
// }

// #tr2 th:first-child{
//     border-top: 2px solid #ddd;
// }

// #tr2 th:first-child{
//     border-left: 2px solid #ddd;
// }

// #tr2 th:last-child{
//     border-right: 2px solid #ddd;
// }

// tr td:first-child{
//     border-left: 2px solid #ddd;
// }

// tr td:last-child{
//     border-right: 2px solid #ddd;
// }

// .blank {
//   background-color: #FFFFFF;
//   border: none;
// }

// .estimatedAmountClass {
//    border-top-left-radius: 25px;
// }

// .totalClass {
//    border-top-right-radius: 25px;
// }

// table th,
// table td {
//   padding: .625em;
//   text-align: center;
// }

// table th {
//   font-size: .85em;
//   letter-spacing: .1em;
//   text-transform: uppercase;
// }
// table {
//   border-collapse: separate;
//   border-spacing: 0;
//   margin: 0;
//   padding: 0;
//   width: 100%;
//   table-layout: fixed;
// }

// tbody tr:hover {
//   background-color: #F3F3F3;
// }

// th ,td {
//   border-right:2px solid #ddd;
//   border-bottom: 2px solid #ddd;
//   background-color: #FFFFF;
//   padding: .35em;
// }

// #tr1 th:last-child {
//     border-top: 2px solid #ddd;
// }

// #tr1 th:nth-child(2) {
//   border-left: 2px solid #ddd;
//   border-top: 2px solid #ddd;
// }

// #tr2 th:first-child{
//     border-top: 2px solid #ddd;
// }

// #tr2 th:first-child{
//     border-left: 2px solid #ddd;
// }

// tr td:first-child{
//     border-left: 2px solid #ddd;
// }

// .blank {
//   background-color: #FFFFFF;
//   border: none;
// }

// .estimatedAmountClass {
//    border-top-left-radius: 25px;
// }

// .totalClass {
//    border-top-right-radius: 25px;
// }

// table th,
// table td {
//   padding: .625em;
//   text-align: center;
// }

// table th {
//   font-size: .85em;
//   letter-spacing: .1em;
//   text-transform: uppercase;
// }

// SELECT
//     t1.title,
//     COALESCE(t2.amount, 0) AS expenses,
//     COALESCE(t3.amount, 0) AS incomes
// FROM accounts t1
// LEFT JOIN
// (
//     SELECT account_id, SUM(amount) AS amount
//     FROM expenses
//     WHERE created_at >= '2019-06-13 20:11:46' AND created_at <= '2019-08-21 21:11:46'
//     GROUP BY account_id
// ) t2
//     ON t1.id = t2.account_id
// LEFT JOIN
// (
//     SELECT account_id, SUM(amount) AS amount
//     FROM incomes
//     WHERE created_at >= '2019-06-11 21:07:57' AND created_at <= '2019-08-21 21:11:46'
//     GROUP BY account_id
// ) t3
//     ON t1.id = t3.account_id
// ORDER BY
//     t1.title;