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

Route::prefix('companies/')->group(function (){
    Route::get('/get','App\Http\Controllers\Companies\ControllerCompanies@index');
    Route::post('/create','App\Http\Controllers\Companies\ControllerCompanies@create');
    Route::put('/update/{id}','App\Http\Controllers\Companies\ControllerCompanies@update');
    Route::delete('/delete/{id}','App\Http\Controllers\Companies\ControllerCompanies@destroy');
});

Route::prefix('employees/')->group(function (){
    Route::get('/get','App\Http\Controllers\Employees\ControllerEmployees@index');
    Route::post('/create','App\Http\Controllers\Employees\ControllerEmployees@create');
    Route::put('/update/{id}','App\Http\Controllers\Employees\ControllerEmployees@update');
    Route::delete('/delete/{id}','App\Http\Controllers\Employees\ControllerEmployees@delete');
});

Route::post('/register','App\Http\Controllers\Auth\ControllerRegister@index');
