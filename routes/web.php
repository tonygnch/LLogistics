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

Route::get('/', 'Home\HomeController@index');

//Trucks
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