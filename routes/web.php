<?php

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
// Route::get('/foo', function () {
    // Artisan::call('storage:link');
    // });
   

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/logoutuser', 'UserController@logout');



Auth::routes();
Route::prefix('/app')->group(function () {
    Route::resource('/user', 'UserController');
    Route::resource('/document', 'Dashboard\DocumentController');
    Route::resource('/machine', 'Dashboard\MachineController');
    Route::resource('/task', 'Dashboard\TaskController');
    Route::resource('/taskdetail', 'Dashboard\TaskDetailController');

    Route::resource('/dashboardoverview', 'Dashboard\DashboardController');
    Route::resource('/pages', 'Dashboard\PagesController');



});


Route::get('/app/getunsignmachine','Dashboard\MachineController@getunsignmachine');
Route::get('/app/getunsigadmin','Dashboard\MachineController@getunsigadmin');
Route::get('/app/getmachinetask/{id}','Dashboard\TaskDetailController@getmachinetask');


Route::get('/app/getunsignmachinetask','Dashboard\TaskController@getunsignmachine');

Route::get('/app/useradmin','Dashboard\PagesController@getAdminUser');

Route::get('/app/getuserpages/{id}','Dashboard\PagesController@getuserpages');

Route::get('/app/getusertype/{id}','Dashboard\PagesController@getuserType');








//setting
Route::post('/app/updateUser','UserController@updateUser');
Route::get('/app/profile', 'UserController@profile');
Route::post('/app/changepassword', 'UserController@changePass');
Route::post('/app/updatepassword', 'UserController@updatepassword');
Route::post('/app/avatar','UserController@avatar');




Route::any('/{slug}/{child}', [
    'uses' => 'HomeController@dashboard',
 ]);
Route::any('/{slug}/{child}/{sub}', [
    'uses' => 'HomeController@dashboard',
 ]);
Route::any('/{slug}/{child}/{sub}/{id}', [
    'uses' => 'HomeController@dashboard',
 ]);

