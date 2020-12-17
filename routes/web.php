<?php

use App\Http\Controllers\todolistController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',[todolistController::class,'index']);
Route::get('loaddata',[todolistController::class,'loaddata']);
Route::post('store',[todolistController::class,'store']);
Route::post('destroy',[todolistController::class,'destroy']);
Route::post('destroyAll',[todolistController::class,'destroyAll']);
Route::post('edit',[todolistController::class,'edit']);
Route::post('update',[todolistController::class,'update']);
