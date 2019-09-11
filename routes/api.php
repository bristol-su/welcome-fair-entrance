<?php

use App\Http\Controllers\Api\ScanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Search for a uid by details
Route::get('/uid', 'Api\UidController@search');
// Create a UID scan
Route::post('/uid', 'Api\UidController@store');

// New Scan and all scans
Route::apiResource('scan', 'Api\ScanController')->only(['store', 'index']);


Route::post('/qrcode', 'Api\QrCodeController@store');
Route::post('/qrcode/redeem', 'Api\QrCodeController@redeem');
