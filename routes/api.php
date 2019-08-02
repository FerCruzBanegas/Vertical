<?php
use Illuminate\Http\Request;
use App\Http\Resources\Expense\ExpenseCollection;
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
        // $route = $;
        // return response()->json($route);

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
    
    $expenses = \App\Expense::orderBy('id', 'DESC');

    $expenses = $expenses->paginate(5);
    return new ExpenseCollection($expenses); 
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

    //User yes
    Route::get('users', 'UserController@index')->name('users.index');
    Route::get('users/{id}/detail', 'UserController@detail')->name('users.show');
    Route::post('users', 'UserController@store')->name('users.create');
    Route::get('users/{id}', 'UserController@show');
    Route::put('users/{id}', 'UserController@update')->name('users.update');
    Route::put('users/{id}/password', 'UserController@password')->name('users.update');
    Route::delete('users/{id}', 'UserController@destroy')->name('users.destroy');

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
});

//LEER
// 1.- Validar que los proyectos no se puedan finalizar sin ningun evento de ingresos o egresos.
// 2.- Validar que los proeyectos finalisados no aparescan para ser seleccionados.
// 3.- validar montos en formularios de egresos
// 4.- ver permisos para actualizar contrasena de un usuario