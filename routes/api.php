<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskBoardController;
use App\Http\Controllers\TaskController;
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

Route::middleware('api')->group(function () {
    Route::POST('register', [UserController::class, 'RegistrationUser']);
    Route::POST('login', [UserController::class, 'login']);
   

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('profile', [UserController::class, 'show']);

        Route::get('all_taskboard', [TaskBoardController::class, 'index']);    // listing of TaskBoard
        Route::POST('create_taskboard', [TaskBoardController::class, 'create']);  // create TaskBoard with POst 
        Route::PUT('update', [TaskBoardController::class, 'edit']);  // update  TaskBoard with Put 
        Route::get('delete_taskboard', [TaskBoardController::class, 'destroy']);  // softdelete  TaskBoard  


        Route::get('all_task', [TaskController::class, 'index']);    // listing of TaskBoard
        Route::POST('create_task', [TaskController::class, 'create']);  // create TaskBoard with POst 
        Route::PUT('update', [TaskController::class, 'edit']);  // update  TaskBoard with Put 
        Route::get('delete_task', [TaskController::class, 'destroy']);  // softdelete  TaskBoard  
    });

});
