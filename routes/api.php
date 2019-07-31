<?php
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


Route::get('/test', function() {

    $actions = \App\Action::select('title', 'name', 'id')->get();
    $test = array(
            ['title' => 'Sistema', 'permissions' => array(['id' => 1, 'name' => 'Acceso Total'])],
            ['title' => 'Egresos', 'permissions' => array(['id' => 2, 'name' => 'Ver Lista'],['id' => 3, 'name' => 'Ver Detalle'],['id' => 4, 'name' => 'Registrar'],['id' => 5, 'name' => 'Actualizar'],['id' => 6, 'name' => 'Actualizar'])],
            ['title' => 'Ingresos', 'permissions' => array(['id' => 7, 'name' => 'Ver Lista'],['id' => 8, 'name' => 'Ver Detalle'],['id' => 9, 'name' => 'Registrar'],['id' => 10, 'name' => 'Actualizar'],['id' => 11, 'name' => 'Actualizar'])]
        );
        // foreach ($actions as $key => $value) {
        //     $data[$key]['title'] = $value->title;
        // }
        
        $data = array();
        $actions->each(function ($item, $key) use(&$data) {
            $data[$key]['title'] = $item->title;
        });
        $data = collect($data)->unique()->values()->toArray();
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
        $grouped = $actions->groupBy('title')->values()->transform(function ($item) {
            return [
                'title' => $item->first()->only(['title']),
                'permissions' => $item
            ];
        });
        $expiresAt = Carbon::now()->addMinutes(10);
        return response()->json($expiresAt);

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
});

// \DB::listen(function($query) {
//     var_dump($query->sql);
// });

Route::post('/login', 'Auth\AuthController@login');

Route::get('project-types/listing', 'ProjectTypeController@listing');
Route::get('projects/listing', 'ProjectController@listing');
Route::get('material-types/listing', 'MaterialTypeController@listing');
Route::get('income-types/listing', 'IncomeTypeController@listing');
Route::get('expense-types/listing', 'ExpenseTypeController@listing');
Route::get('people/listing', 'PersonController@listing');
Route::get('profiles/listing', 'ProfileController@listing');
Route::get('actions/listing', 'ActionController@listing');

Route::group(['middleware' => ['auth:api', 'acl:api']], function () {
    Route::post('logout', 'Auth\AuthController@logout');

    //User
    Route::get('users', 'UserController@index')->name('users.index');
    Route::get('users/{id}', 'UserController@show');
    Route::get('users/{id}/detail', 'UserController@detail');
    Route::post('users', 'UserController@store')->name('users.create');
    Route::put('users/{id}', 'UserController@update')->name('users.update');
    Route::delete('users/{id}', 'UserController@destroy')->name('users.destroy');
    Route::put('users/{id}/password', 'UserController@password')->name('users.update');

    //Project-Types
    Route::get('project-types', 'ProjectTypeController@index')->name('project-types.index');
    Route::get('project-types/{id}', 'ProjectTypeController@show');
    Route::get('project-types/{id}/detail', 'ProjectTypeController@detail');
    Route::post('project-types', 'ProjectTypeController@store')->name('project-types.create');
    Route::put('project-types/{id}', 'ProjectTypeController@update')->name('project-types.update');
    Route::delete('project-types/{id}', 'ProjectTypeController@destroy')->name('project-types.destroy');

    //Project
    Route::get('projects', 'ProjectController@index')->name('projects.index');
    Route::get('projects/{id}', 'ProjectController@show');
    Route::get('projects/{id}/detail', 'ProjectController@detail');
    Route::get('projects/{id}/events', 'ProjectController@getEvents');
    Route::get('projects/{id}/finish', 'ProjectController@finishProject');
    Route::post('projects', 'ProjectController@store')->name('projects.create');
    Route::put('projects/{id}', 'ProjectController@update')->name('projects.update');
    Route::delete('projects/{id}', 'ProjectController@destroy')->name('projects.destroy');

    //Material-Types
    Route::get('material-types', 'MaterialTypeController@index')->name('material-types.index');
    Route::get('material-types/{id}', 'MaterialTypeController@show');
    Route::post('material-types', 'MaterialTypeController@store')->name('material-types.create');
    Route::put('material-types/{id}', 'MaterialTypeController@update')->name('material-types.update');
    Route::delete('material-types/{id}', 'MaterialTypeController@destroy')->name('material-types.destroy');

    //Material
    Route::get('materials', 'MaterialController@index')->name('materials.index');
    Route::get('materials/{id}', 'MaterialController@show');
    Route::get('materials/{id}/detail', 'MaterialController@detail');
    Route::get('search-material/{name}', 'MaterialController@searchMaterial');
    Route::post('materials', 'MaterialController@store')->name('materials.create');
    Route::put('materials/{id}', 'MaterialController@update')->name('materials.update');
    Route::delete('materials/{id}', 'MaterialController@destroy')->name('materials.destroy');

    //Income-Types
    Route::get('income-types', 'IncomeTypeController@index')->name('income-types.index');
    Route::get('income-types/{id}', 'IncomeTypeController@show');
    Route::post('income-types', 'IncomeTypeController@store')->name('income-types.create');
    Route::put('income-types/{id}', 'IncomeTypeController@update')->name('income-types.update');
    Route::delete('income-types/{id}', 'IncomeTypeController@destroy')->name('income-types.destroy');

    //Income
    Route::get('incomes', 'IncomeController@index')->name('incomes.index');
    Route::get('incomes/amounts', 'IncomeController@amounts');
    Route::get('incomes/{id}', 'IncomeController@show');
    Route::get('incomes/{id}/detail', 'IncomeController@detail');
    Route::post('incomes', 'IncomeController@store')->name('incomes.create');
    Route::put('incomes/{id}', 'IncomeController@update')->name('incomes.update');
    Route::delete('incomes/{id}', 'IncomeController@destroy')->name('incomes.destroy');

    //Expense-Types
    Route::get('expense-types', 'ExpenseTypeController@index')->name('expense-types.index');
    Route::get('expense-types/{id}', 'ExpenseTypeController@show');
    Route::post('expense-types', 'ExpenseTypeController@store')->name('expense-types.create');
    Route::put('expense-types/{id}', 'ExpenseTypeController@update')->name('expense-types.update');
    Route::delete('expense-types/{id}', 'ExpenseTypeController@destroy')->name('expense-types.destroy');

    //Expense
    Route::get('expenses', 'ExpenseController@index')->name('expenses.index');
    Route::get('expenses/amounts', 'ExpenseController@amounts');
    Route::get('expenses/{id}', 'ExpenseController@show');
    Route::get('expenses/{id}/detail', 'ExpenseController@detail');
    Route::post('expenses', 'ExpenseController@store')->name('expenses.create');
    Route::put('expenses/{id}', 'ExpenseController@update')->name('expenses.update');
    Route::delete('expenses/{id}', 'ExpenseController@destroy')->name('expenses.destroy');

    //People
    Route::get('people', 'PersonController@index')->name('people.index');
    Route::get('people/{id}', 'PersonController@show');
    Route::get('search-person/{name}', 'PersonController@searchPerson');
    Route::post('people', 'PersonController@store')->name('people.create');
    Route::put('people/{id}', 'PersonController@update')->name('people.update');
    Route::delete('people/{id}', 'PersonController@destroy')->name('people.destroy');

    //Profiles
    Route::get('profiles', 'ProfileController@index')->name('profiles.index');
    Route::get('profiles/{id}', 'ProfileController@show');
    Route::post('profiles', 'ProfileController@store')->name('profiles.create');
    Route::put('profiles/{id}', 'ProfileController@update')->name('profiles.update');
    Route::delete('profiles/{id}', 'ProfileController@destroy')->name('profiles.destroy');
});

//LEER
// 1.- Validar que los proyectos no se puedan finalizar sin ningun evento de ingresos o egresos.
// 2.- Validar que los proeyectos finalisados no aparescan para ser seleccionados.