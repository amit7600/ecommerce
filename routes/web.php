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

Route::get('/login', function () {
    \Auth::logout();
    return view('Admin.login');
});

Route::get('/cache_clear', function () {
    \Artisan::call('config:cache');
    \Artisan::call('config:clear');
    \Artisan::call('route:clear');
    \Artisan::call('view:clear');
    echo 'All clear';
});

Route::get('/logout', function () {
    \Auth::logout();
    return redirect()->to('/login');
});
Route::post('login, Admin\LoginCotroller@login');


Route::view('/', 'mainApp');

Auth::routes();

Route::get('locale/{locale}', 'HomeController@changeLocale');
Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    

    // product
    Route::post('attributes/destroyChild', 'Admin\AttributeController@destroyChild');
    Route::post('products/image-upload', 'Admin\ProductController@imageUploadPost')->name('products.image-upload');
    Route::get('products/image-upload', 'Admin\ProductController@imageUpload');
    Route::get('products/import-export', 'Admin\ProductController@importExport');
    Route::get('products/export', 'Admin\ExcelController@export');


    // resource route
    Route::resource('attributes', 'Admin\AttributeController');
    Route::resource('products', 'Admin\ProductController');
    Route::resource('orders', 'Admin\OrderController');
    Route::resource('roles', 'Admin\RolesController');
    Route::resource('tax', 'Admin\TaxController');
    Route::resource('category', 'Admin\CategoryController');
    Route::resource('offers', 'Admin\OfferController');
    Route::resource('users', 'Api\UserController');

     //amit
	Route::resource('sms_template', 'Admin\SMSTemplateController');
	Route::resource('email_template', 'Admin\EmailTemplateController');
	Route::post('emailStatus/{id}', 'Admin\EmailTemplateController@status');
	Route::post('smsStatus/{id}', 'Admin\SMSTemplateController@status');
	Route::resource('users', 'Admin\UserController');
	Route::post('userStatus/{id}', 'Admin\UserController@status');
	// Route::get('send_email/{id}', 'Admin\EmailTemplateController@send_email');
});

// For reload page of vue routes 
Route::get('{any}', function () {
    return view('mainApp');
})->where('any','.*');
