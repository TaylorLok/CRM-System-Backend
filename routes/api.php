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

//Login
Route::post('/login', [App\Http\Controllers\api\LoginController::class, 'login']);
Route::post('/logout',[App\Http\Controllers\api\LoginController::class, 'logout']);

//Client
Route::get('/clients', [App\Http\Controllers\api\ClientController::class, 'index']);
Route::get('/clients/{id}', [App\Http\Controllers\api\ClientController::class, 'view']);
Route::get('/clients/filter/{search?}', [App\Http\Controllers\api\ClientController::class, 'filter']);
Route::get('/clients/filterClient', [App\Http\Controllers\api\ClientController::class, 'filterClient']);
Route::post('/create/client', [App\Http\Controllers\api\ClientController::class, 'save']);
Route::put('/client/{id}/update', [App\Http\Controllers\api\ClientController::class, 'update']);
Route::delete('/delete/client/{id}', [App\Http\Controllers\api\ClientController::class, 'delete']);