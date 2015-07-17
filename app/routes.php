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

Route::get('/', 'StaticController@home');
Route::get('/contact-us', 'StaticController@contactUs');
Route::get('/about-us', 'StaticController@aboutUs');
Route::get('/terms-and-conditions', 'StaticController@termsAndConditions');
Route::get('/privacy-policy', 'StaticController@privacyPolicy');

Route::get('/institute', 'SearchController@home');
Route::get('/course', 'SearchController@home');
Route::get('/book', 'SearchController@home');

Route::get('/admin-login', 'AuthenticationController@adminLogin');

Route::post('/is-valid-admin', 'AuthenticationController@isValidAdmin');

Route::get('/add-institute', 'InstituteController@add');
Route::post('/save-institute', 'InstituteController@save');
Route::get('/edit-institute', 'InstituteController@edit');
Route::post('/update-institute', 'InstituteController@update');
Route::get('/get-institute/{id}', 'InstituteController@getInstitute');
Route::get('/institutes', 'InstituteController@institutes');
Route::get('/list-institutes/{page?}/{city?}/{country?}', 'InstituteController@listInstitutes');
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

Route::get('/remove-user/{id}', 'UserController@remove');

Route::get('/remove-courier/{id}', 'CourierController@remove');
Route::get('/edit-courier', 'CourierController@edit');
Route::post('/update-courier', 'CourierController@update');
Route::post('/save-courier', 'CourierController@save');

Route::get('/remove-software-user/{id}', 'SoftwareUserController@remove');
Route::get('/edit-software-user', 'SoftwareUserController@edit');
Route::post('/update-software-user', 'SoftwareUserController@update');
Route::post('/save-software-user', 'SoftwareUserController@save');

Route::get('/remove-location/{id}', 'LocationController@remove');
Route::get('/edit-location', 'LocationController@edit');
Route::post('/update-location', 'LocationController@update');
Route::post('/save-location', 'LocationController@save');

Route::get('/search-cities', 'SearchController@searchCities');
Route::get('/search-keyword/{type}', 'SearchController@searchByKeyword');

/********************** admin urls ************************/
Route::get('/admin-section', 'AdminController@adminSection');
Route::get('/admin-institutes', 'AdminController@institutes');
Route::get('/admin-courses/{id}', 'AdminController@courses');
Route::get('/admin-books/{id}', 'AdminController@books');
Route::get('/admin-orders', 'AdminController@orders');
Route::get('/admin-couriers', 'AdminController@couriers');
Route::get('/admin-users', 'AdminController@users');
Route::get('/admin-software-users', 'AdminController@softwareUsers');
Route::get('/admin-locations', 'AdminController@locations');

Route::get('/admin-list-institutes/{status}/{page}', 'AdminController@listInstitutes');
Route::get('/admin-list-orders/{status}/{page}', 'AdminController@listOrders');
Route::get('/admin-list-courses/{status}/{page}', 'AdminController@listCourses');
Route::get('/admin-list-books/{status}/{page}', 'AdminController@listBooks');
Route::get('/admin-list-couriers/{status}/{page}', 'AdminController@listCouriers');
Route::get('/admin-list-software-users/{status}/{page}', 'AdminController@listSoftwareUsers');
Route::get('/admin-list-users/{status}/{page}', 'AdminController@listUsers');
Route::get('/admin-list-locations/{status}/{page}', 'AdminController@listLocations');

Route::get('/admin-view-institute/{id}', 'AdminController@viewInstitute');
Route::get('/admin-view-course/{id}', 'AdminController@viewCourse');
Route::get('/admin-view-book/{id}', 'AdminController@viewBook');
Route::get('/admin-view-courier/{id}', 'AdminController@viewCourier');
Route::get('/admin-view-software-user/{id}', 'AdminController@viewSoftwareUser');
Route::get('/admin-view-user/{id}', 'AdminController@viewUser');
Route::get('/admin-view-location/{id}', 'AdminController@viewLocation');
Route::get('/admin-view-order/{id}', 'AdminController@viewOrder');

Route::get('/logout', 'AuthenticationController@logout');