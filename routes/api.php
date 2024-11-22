<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['middleware' => 'auth:sanctum'], function(){
    
    Route::apiResource('employee', EmployeeController::class);
    Route::get('list/{id?}', [DeviceController::class, 'list']);
    Route::post('list/add', [DeviceController::class, 'add']);
    Route::put('list/{id}/update', [DeviceController::class, 'update']);
    Route::get('search/{query}', [DeviceController::class, 'search']);
    Route::delete('delete/{id}', [DeviceController::class, 'delete']);
    Route::post('upload', [DeviceController::class, 'upload']);

});

Route::post('auth/login', [AuthController::class, 'store']);
Route::post('auth/register', [AuthController::class, 'create']);