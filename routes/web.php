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

Route::get('/test', function () {
    return view('auth.login');
});

Auth::routes();



Route::group(['middleware' => ['auth'], 'namespace' => 'Backend'], function() {

    //['middleware' => ['permission:publish articles|edit articles']], function
//->middleware(['permission:User View|User Edit']);

	Route::get('/', 'DashboardController@index')->name('dashboard');
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


    //User Master
    Route::group(['middleware' => ['permission:User Master']], function() {
        Route::get('/users', 'UserController@index')->name('user-list')->middleware(['permission:User List']);
        Route::get('/users/create', 'UserController@create')->name('user-create')->middleware(['permission:User Create']);
        Route::post('/users/store', 'UserController@store')->name('user-save')->middleware(['permission:User Create']);
        Route::get('/users/edit/{id}', 'UserController@edit')->name('user-edit')->middleware(['permission:User Edit']);
        Route::post('/users/update/{id}', 'UserController@update')->name('user-update')->middleware(['permission:User Edit']);
        Route::get('/ajax/users/view/{id}', 'UserController@show')->name('user-view')->middleware(['permission:User View']);
    });
	
	
	
	//Business Master
    Route::group(['middleware' => ['permission:Business Master']], function() {
        Route::get('/business/list', 'BusinessController@index')->name('business-list')->middleware(['permission:Business List']);
        Route::get('/business/create', 'BusinessController@create')->name('business-create')->middleware(['permission:Business Create']);
        Route::Post('/business/store', 'BusinessController@store')->name('business-store')->middleware(['permission:Business Create']);
        Route::get('/business/edit/{id}', 'BusinessController@edit')->name('business-edit')->middleware(['permission:Business Edit']);
        Route::Post('/business/update/{id}', 'BusinessController@update')->name('business-update')->middleware(['permission:Business Edit']);
       });
	   
	 //Store Master
    Route::group(['middleware' => ['permission:Store Master']], function() {
        Route::get('/store/list', 'StoreController@index')->name('store-list')->middleware(['permission:Store List']);
        Route::get('/store/create', 'StoreController@create')->name('store-create')->middleware(['permission:Store Create']);
        Route::Post('/store/store', 'StoreController@store')->name('store-store')->middleware(['permission:Store Create']);
        Route::get('/store/edit/{id}', 'StoreController@edit')->name('store-edit')->middleware(['permission:Store Edit']);
        Route::Post('/store/update/{id}', 'StoreController@update')->name('store-update')->middleware(['permission:Store Edit']);
       });
	

    
    Route::get('/setting', 'SettingController@index')->name('setting');
    Route::post('/setting/password/update', 'SettingController@updatePassword')->name('password-update');


    Route::get('/roles-list', 'RolePermissionController@roles')->name('roles-list');
    Route::get('/roles/create', 'RolePermissionController@create')->name('roles-create');
    Route::post('/roles/store', 'RolePermissionController@store')->name('roles-store');
    Route::get('/roles/edit/{id}', 'RolePermissionController@edit')->name('roles-edit');
    Route::post('/roles/update/{id}', 'RolePermissionController@update')->name('roles-update');
    Route::get('/ajax/roles/view/{id}', 'RolePermissionController@show')->name('roles-view');


});
