<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/add-institute', 'InstituteController@add');
Route::get('/save-institute', 'InstituteController@save');

Route::get('/edit-institute', 'InstituteController@edit');
Route::get('/update-institute', 'InstituteController@update');

Route::get('/get-institute/{id}', 'InstituteController@getInstitute');
Route::get('/list-institutes/{page}/{city?}/{country?}', 'InstituteController@listInstitutes');

Route::get('/get-courses/{id}', 'InstituteController@getCourses');
Route::get('/get-course-books/{id}', 'InstituteController@getCourseBooks');
