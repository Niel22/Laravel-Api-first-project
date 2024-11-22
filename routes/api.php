<?php

use App\Http\Controllers\DeviceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('list/{id?}', [DeviceController::class, 'list']);
Route::post('list/add', [DeviceController::class, 'add']);
Route::put('list/{id}/update', [DeviceController::class, 'update']);
Route::get('search/{query}', [DeviceController::class, 'search']);
Route::delete('delete/{id}', [DeviceController::class, 'delete']);
