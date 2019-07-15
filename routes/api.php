<?php

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

Route::group(['middleware' => ['auth:api']], function () {//TODO Borre el midleware 'acl:api'
    Route::post('logout', 'Auth\AuthController@logout');
    Route::get('users', 'UserController@index')->name('users.index');

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
    Route::get('incomes', 'IncomeController@index')->name('income.index');
    Route::get('incomes/amounts', 'IncomeController@amounts');
    Route::get('incomes/{id}', 'IncomeController@show');
    Route::get('incomes/{id}/detail', 'IncomeController@detail');
    Route::post('incomes', 'IncomeController@store')->name('income.create');
    Route::put('incomes/{id}', 'IncomeController@update')->name('income.update');
    Route::delete('incomes/{id}', 'IncomeController@destroy')->name('income.destroy');

    //Expense-Types
    Route::get('expense-types', 'ExpenseTypeController@index')->name('expense-types.index');
    Route::get('expense-types/{id}', 'ExpenseTypeController@show');
    Route::post('expense-types', 'ExpenseTypeController@store')->name('expense-types.create');
    Route::put('expense-types/{id}', 'ExpenseTypeController@update')->name('expense-types.update');
    Route::delete('expense-types/{id}', 'ExpenseTypeController@destroy')->name('expense-types.destroy');

    //Expense
    Route::get('expenses', 'ExpenseController@index')->name('expense.index');
    Route::get('expenses/amounts', 'ExpenseController@amounts');
    Route::get('expenses/{id}', 'ExpenseController@show');
    Route::get('expenses/{id}/detail', 'ExpenseController@detail');
    Route::post('expenses', 'ExpenseController@store')->name('expense.create');
    Route::put('expenses/{id}', 'ExpenseController@update')->name('expense.update');
    Route::delete('expenses/{id}', 'ExpenseController@destroy')->name('expense.destroy');

});
