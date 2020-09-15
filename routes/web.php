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



Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/dashboard', function() {
    return view('dashboard/dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/home', function() {
    return view('dashboard/dashboard');
})->name('home')->middleware('auth');

Route::get('/import', 'ImportController@getImport')->name('import');
Route::post('/import_parse', 'ImportController@parseImport')->name('import_parse');
Route::post('/import_process', 'ImportController@processImport')->name('import_process');

Route::get('/leads', 'LeadsController@Index')->name('contactszz');

Route::get('/contacts', 'LeadsController@contacts')->name('contacts');

Route::get('/newleads', 'ImportController@getNewLeads')->name('newleads');
Route::post('/newleads_parse', 'ImportController@parseNewLeads')->name('newleads_parse');
Route::post('/newleads_process', 'ImportController@processNewLeads')->name('newleads_process');
Route::get('/new_leads_report', 'ImportController@newleadsReport')->name('newleadsReport');


Route::get('/campaigns', 'CampaignController@index')->name('campaigns');
Route::post('/createcampaign', 'CampaignController@createCampaign')->name('createCampaign');
Route::get('/deletecampaign/{id}', 'CampaignController@deleteCampaign')->name('deleteCampaign');
Route::post('/editcampaign', 'CampaignController@editCampaign')->name('editCampaign');



/**
 * middleware('App\Http\Middleware\AdminMiddleware')->
 * Route::get('/', 'ImportController@getImport')->name('import');
Route::post('/import_parse', 'ImportController@parseImport')->name('import_parse');
Route::post('/import_process', 'ImportController@processImport')->name('import_process'); */