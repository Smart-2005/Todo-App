<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('api/v1/tasks/store',[TaskController::class,'store']);
Route::get('api/v1/tasks/get',[TaskController::class,'retrieve']);

Route::put('api/v1/tasks/edit/{id}',[TaskController::class,'update']);
Route::post('api/v1/tasks/edit/{id}',[TaskController::class,'update']);

Route::delete('api/v1/tasks/delete/{id}',[TaskController::class,'delete']);