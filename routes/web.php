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

var_dump('test');
exit;

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

//Trailers
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