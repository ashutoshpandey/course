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
Route::post('/save-institute', 'InstituteController@save');

Route::get('/edit-institute', 'InstituteController@edit');
Route::get('/update-institute', 'InstituteController@update');

Route::get('/get-institute/{id}', 'InstituteController@getInstitute');
Route::get('/list-institutes/{page}/{city?}/{country?}', 'InstituteController@listInstitutes');

Route::get('/get-courses/{id}', 'InstituteController@getCourses');
Route::get('/get-course-books/{id}', 'InstituteController@getCourseBooks');

/********************** admin urls ************************/
Route::get('/admin-section', 'AdminController@adminSection');
Route::get('/admin-institutes', 'AdminController@institutes');
Route::get('/admin-courses/{id}', 'AdminController@courses');
Route::get('/admin-books/{id}', 'AdminController@books');
Route::get('/admin-orders', 'AdminController@orders');

Route::get('/admin-list-institutes/{status}/{page}', 'AdminController@listInstitutes');
Route::get('/admin-list-orders/{status}/{page}', 'AdminController@listOrders');
Route::get('/admin-list-courses/{id}/{status}/{page}', 'AdminController@listCourses');
Route::get('/admin-list-books/{id}/{status}/{page}', 'AdminController@listBooks');