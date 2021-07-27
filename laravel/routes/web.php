<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Tag
Route::post('app/create_tag', 'AdminController@addTag');
Route::get('app/get_tags', 'AdminController@getTag');
Route::post('app/edit_tag', 'AdminController@editTag');
Route::post('app/delete_tag', 'AdminController@deleteTag');
// Category
Route::post('app/upload', 'AdminController@upload');
Route::post('app/delete_image', 'AdminController@deleteImage');
Route::post('app/create_category', 'AdminController@addCategory');
Route::get('app/get_categories', 'AdminController@getCategories');
Route::post('app/edit_category', 'AdminController@editCategory');
Route::post('app/delete_category', 'AdminController@deleteCategory');
// User
Route::post('app/create_users', 'AdminController@createUser');
Route::get('app/get_users', 'AdminController@getUsers');
Route::post('app/edit_user', 'AdminController@editUser');
Route::post('app/admin_login', 'AdminController@adminLogin');


Route::get('/logout', 'AdminController@logout');
Route::get('/', 'AdminController@index');
Route::any('{slug}', 'AdminController@index');


// Route::get('/new', 'TestController@controllerMethod');
// Route::any('{slug}', function () {
//     return view('welcome');
// });
