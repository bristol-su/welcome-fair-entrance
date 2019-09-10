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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

// No Student Card Routes
Route::middleware('guest')->group(function() {
    Route::get('/', 'NoCardController@index');
    Route::post('/', 'NoCardController@store');
});

// Administrator Routes
Route::middleware('auth:web')->group(function() {

    Route::get('/dashboard', 'HomeController@index');
    Route::get('/demographics', 'HomeController@demographics');

    Route::get('/scan', 'ScanController@index');
    Route::get('/scan/create', 'ScanController@create');

    Route::get('/lookup', 'UidController@index');
});

