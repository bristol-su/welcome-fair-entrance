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

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');
Route::get('/demographics', 'HomeController@demographics');

Route::get('/scan', 'ScanController@index');
Route::get('/scan/create', 'ScanController@create');

Route::get('/uid', 'UidController@index');

Route::get('/no-card', 'NoCardController@index');
Route::get('/no-card/student', 'NoCardController@create');
Route::post('/no-card/student', 'NoCardController@store');
