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

Route::post('/login', 'Auth\AuthController@login');

Route::get('project-types/listing', 'ProjectTypeController@listing');
Route::get('projects/listing', 'ProjectController@listing');
Route::get('categories/listing', 'CategoryController@listing');

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

});
