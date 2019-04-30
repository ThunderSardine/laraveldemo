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

Route::group(['middleware' => ['auth']], function ()
{

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/contacts', 'ContactController@index');
    Route::post('/contact/store','ContactController@store');
    Route::get('/contact/{id}', 'ContactController@show');
    Route::patch('/contact/{id}', 'ContactController@update');
    Route::delete('/contact/{id}', 'ContactController@destroy');

});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
