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

Route::get('/admin-login', 'AuthenticationController@adminLogin');

Route::post('/is-valid-admin', 'AuthenticationController@isValidAdmin');

Route::get('/add-institute', 'InstituteController@add');
Route::post('/save-institute', 'InstituteController@save');
Route::get('/edit-institute', 'InstituteController@edit');
Route::post('/update-institute', 'InstituteController@update');
Route::get('/get-institute/{id}', 'InstituteController@getInstitute');
Route::get('/list-institutes/{page}/{city?}/{country?}', 'InstituteController@listInstitutes');
Route::get('/remove-institute/{id}', 'InstituteController@remove');

Route::get('/get-courses/{id}', 'InstituteController@getCourses');
Route::get('/get-course-books/{id}', 'CourseController@getCourseBooks');
Route::get('/remove-course/{id}', 'CourseController@remove');
Route::get('/edit-course', 'CourseController@edit');
Route::post('/update-course', 'CourseController@update');
Route::post('/save-course', 'CourseController@save');

Route::get('/remove-book/{id}', 'BookController@remove');
Route::get('/edit-book', 'BookController@edit');
Route::post('/update-book', 'BookController@update');
Route::post('/save-book', 'BookController@save');

/********************** admin urls ************************/
Route::get('/admin-section', 'AdminController@adminSection');
Route::get('/admin-institutes', 'AdminController@institutes');
Route::get('/admin-courses/{id}', 'AdminController@courses');
Route::get('/admin-books/{id}', 'AdminController@books');
Route::get('/admin-orders', 'AdminController@orders');

Route::get('/admin-list-institutes/{status}/{page}', 'AdminController@listInstitutes');
Route::get('/admin-list-orders/{status}/{page}', 'AdminController@listOrders');
Route::get('/admin-list-courses/{status}/{page}', 'AdminController@listCourses');
Route::get('/admin-list-books/{status}/{page}', 'AdminController@listBooks');

Route::get('/admin-view-institute/{id}', 'AdminController@viewInstitute');
Route::get('/admin-view-course/{id}', 'AdminController@viewCourse');
Route::get('/admin-view-book/{id}', 'AdminController@viewBook');

Route::get('/logout', 'AuthenticationController@logout');