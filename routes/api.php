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

Route::group(['middleware' => 'api'], function ($router) {
    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
        Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
        Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
        Route::post('/refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
    });

    Route::group(['prefix' => 'trainer'], function ($router) {
        Route::get('/all-classes', [\App\Http\Controllers\TrainerController::class, 'getAllClasses']);
        Route::get('/class/{id}', [\App\Http\Controllers\TrainerController::class, 'getClass']);
        Route::delete('/class/delete-student/{classroom_id}/{student_id}', [\App\Http\Controllers\TrainerController::class, 'removeStudentFromClassroom']);

    });
});

Route::apiResource('classroom', \App\Http\Controllers\ClassroomController::class);
Route::apiResource('workout', \App\Http\Controllers\WorkoutController::class);


