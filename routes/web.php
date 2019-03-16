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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/ajaxGetLastId/{table}', 'Common\AjaxController@getTableLastId');

Route::get('/', [
    'as' => 'main',
    'uses' => 'Home\HomeController@index'
]);

/**
 * Trucks
 */

Route::get('trucks',[
    'as' => 'trucks',
    'uses' => 'TruckController@index'
]);

Route::get('trucks/add',[
    'as' => 'addTruck',
    'uses' => 'TruckController@add'
]);
Route::post('trucks/add', 'TruckController@add');

Route::get('trucks/modify/{id}',[
    'as' => 'modifyTruck',
    'uses' => 'TruckController@modify'
]);
Route::post('trucks/modify/{id}', 'TruckController@modify');

Route::get('trucks/delete/{id}',[
    'as' => 'deleteTruck',
    'uses' => 'TruckController@delete'
]);


/**
 * Trailers
 */

Route::get('trailers',[
    'as' => 'trailers',
    'uses' => 'TrailerController@index'
]);

Route::get('trailers/add',[
    'as' => 'addTrailer',
    'uses' => 'TrailerController@add'
]);
Route::post('trailers/add', 'TrailerController@add');

Route::get('trailers/modify/{id}',[
    'as' => 'modifyTrailer',
    'uses' => 'TrailerController@modify'
]);
Route::post('trailers/modify/{id}', 'TrailerController@modify');

Route::get('trailers/delete/{id}',[
    'as' => 'deleteTrailer',
    'uses' => 'TrailerController@delete'
]);

/**
 * Clients
 */

Route::get('clients',[
    'as' => 'clients',
    'uses' => 'ClientController@index'
]);

Route::get('clients/add',[
    'as' => 'addClient',
    'uses' => 'ClientController@add'
]);
Route::post('clients/add', 'ClientController@add');

Route::get('clients/modify/{id}',[
    'as' => 'modifyClient',
    'uses' => 'ClientController@modify'
]);
Route::post('clients/modify/{id}', 'ClientController@modify');

Route::get('clients/delete/{id}',[
    'as' => 'deleteClient',
    'uses' => 'ClientController@delete'
]);

/**
 * Invoices
 */

Route::get('invoices',[
    'as' => 'invoices',
    'uses' => 'InvoiceController@index'
]);

Route::get('invoices/add',[
    'as' => 'addInvoice',
    'uses' => 'InvoiceController@add'
]);
Route::post('invoices/add', 'InvoiceController@add');

Route::get('invoices/modify/{id}',[
    'as' => 'modifyInvoice',
    'uses' => 'InvoiceController@modify'
]);
Route::post('invoices/modify/{id}', 'InvoiceController@modify');

Route::get('invoices/delete/{id}',[
    'as' => 'deleteInvoice',
    'uses' => 'InvoiceController@delete'
]);

/**
 * Trips
 */

Route::get('trips',[
    'as' => 'trips',
    'uses' => 'TripController@index'
]);

Route::get('trips/add',[
    'as' => 'addTrip',
    'uses' => 'TripController@add'
]);

Route::post('trips/add', 'TripController@add');

Route::get('trips/modify/{id}',[
    'as' => 'modifyTrip',
    'uses' => 'TripController@modify'
]);
Route::post('trips/modify/{id}', 'TripController@modify');

Route::get('trips/delete/{id}',[
    'as' => 'deleteTrip',
    'uses' => 'TripController@delete'
]);

/**
 * Drivers
 */

Route::get('drivers',[
    'as' => 'drivers',
    'uses' => 'DriverController@index'
]);

Route::get('drivers/add',[
    'as' => 'addDriver',
    'uses' => 'DriverController@add'
]);
Route::post('drivers/add', 'DriverController@add');

Route::get('drivers/modify/{id}',[
    'as' => 'modifyDriver',
    'uses' => 'DriverController@modify'
]);
Route::post('drivers/modify/{id}', 'DriverController@modify');

Route::get('drivers/delete/{id}',[
    'as' => 'deleteDriver',
    'uses' => 'DriverController@delete'
]);

/**
 * Login Stuff
 */

//Login
Route::get('login', [
    'as' => 'login',
    'uses' => 'Auth\LoginController@login'
]);
Route::post('login', 'Auth\LoginController@login');

// Sign up
Route::get('signup', [
    'as' => 'signup',
    'uses' => 'Auth\RegisterController@signUp'
]);
Route::post('signup', 'Auth\RegisterController@signUp');