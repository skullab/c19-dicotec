<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['as' => 'api.', 'namespace' => 'App\Http\Controllers'],function(){
    Route::get('info','VerificaC19Controller@info');
    Route::post('validation','VerificaC19Controller@validation')->name('validation');
    Route::post('update-certificates','VerificaC19Controller@updateCertificates')->name('update-certificates');
});