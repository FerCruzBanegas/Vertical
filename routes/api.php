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

Route::get('/test', function() {
    // $expenses = \App\Expense::with([
    //     'expense_type',
    //     'materials'
    // ])->where('project_id', '=', 35)->get();

    $projectType = \App\ProjectType::findOrFail(62);
    $data =  $projectType->activities()->where('description', 'updated')->orderBy('created_at', 'desc')->first();
    return response()->json($data);
});

// \DB::listen(function($query) {
//     var_dump($query->sql);
// });

Route::post('/login', 'Auth\AuthController@login');

Route::get('project-types/listing', 'ProjectTypeController@listing');
Route::get('projects/listing', 'ProjectController@listing');
Route::get('categories/listing', 'CategoryController@listing');
Route::get('income-types/listing', 'IncomeTypeController@listing');
Route::get('expense-types/listing', 'ExpenseTypeController@listing');

Route::group(['middleware' => ['auth:api']], function () {//TODO Borre el midleware 'acl:api'
    Route::post('logout', 'Auth\AuthController@logout');
    Route::get('users', 'UserController@index')->name('users.index');

    //Project-Types
    Route::get('project-types', 'ProjectTypeController@index')->name('project-types.index');
    Route::get('project-types/{id}', 'ProjectTypeController@show');
    Route::post('project-types', 'ProjectTypeController@store')->name('project-types.create');
    Route::put('project-types/{id}', 'ProjectTypeController@update')->name('project-types.update');
    Route::delete('project-types/{id}', 'ProjectTypeController@destroy')->name('project-types.destroy');

    //Project
    Route::get('projects', 'ProjectController@index')->name('projects.index');
    Route::get('projects/{id}', 'ProjectController@show');
    Route::post('projects', 'ProjectController@store')->name('projects.create');
    Route::put('projects/{id}', 'ProjectController@update')->name('projects.update');
    Route::delete('projects/{id}', 'ProjectController@destroy')->name('projects.destroy');

    //Category
    Route::get('categories', 'CategoryController@index')->name('categories.index');
    Route::get('categories/{id}', 'CategoryController@show');
    Route::post('categories', 'CategoryController@store')->name('categories.create');
    Route::put('categories/{id}', 'CategoryController@update')->name('categories.update');
    Route::delete('categories/{id}', 'CategoryController@destroy')->name('categories.destroy');

    //Material
    Route::get('materials', 'MaterialController@index')->name('materials.index');
    Route::get('materials/{id}', 'MaterialController@show');
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
    Route::get('income', 'IncomeController@index')->name('income.index');
    Route::get('income/{id}', 'IncomeController@show');
    Route::post('income', 'IncomeController@store')->name('income.create');
    Route::put('income/{id}', 'IncomeController@update')->name('income.update');
    Route::delete('income/{id}', 'IncomeController@destroy')->name('income.destroy');

    //Expense-Types
    Route::get('expense-types', 'ExpenseTypeController@index')->name('expense-types.index');
    Route::get('expense-types/{id}', 'ExpenseTypeController@show');
    Route::post('expense-types', 'ExpenseTypeController@store')->name('expense-types.create');
    Route::put('expense-types/{id}', 'ExpenseTypeController@update')->name('expense-types.update');
    Route::delete('expense-types/{id}', 'ExpenseTypeController@destroy')->name('expense-types.destroy');

    //Expense
    Route::get('expense', 'ExpenseController@index')->name('expense.index');
    Route::get('expense/{id}', 'ExpenseController@show');
    Route::post('expense', 'ExpenseController@store')->name('expense.create');
    Route::put('expense/{id}', 'ExpenseController@update')->name('expense.update');
    Route::delete('expense/{id}', 'ExpenseController@destroy')->name('expense.destroy');

});
