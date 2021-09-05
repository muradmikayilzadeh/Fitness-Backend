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

Route::group(['middleware' => 'api'], function ($router) {
    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
        Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
        Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
        Route::post('/refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
    });

    Route::group(['prefix' => 'trainer'], function ($router) {
        Route::get('/class/all', [\App\Http\Controllers\TrainerController::class, 'getAllClasses']);
        Route::get('/class/{id}', [\App\Http\Controllers\TrainerController::class, 'getClass']);
        Route::delete('/class/delete-student/{classroom_id}/{student_id}', [\App\Http\Controllers\TrainerController::class, 'removeStudentFromClassroom']);
        Route::post("/class/assignment/add/{classroom_id}", [\App\Http\Controllers\AssignmentController::class, 'store']);
        Route::delete("/class/assignment/remove/{assignment_id}", [\App\Http\Controllers\AssignmentController::class, 'destroy']);
        Route::post("/class/assignment/workout/add", [\App\Http\Controllers\TrainerController::class, 'addWorkout']);
        Route::post("/class/assignment/workout/remove", [\App\Http\Controllers\TrainerController::class, 'removeWorkout']);
    });

    Route::group(['prefix' => 'student'], function ($router) {
        Route::get('/class/all', [\App\Http\Controllers\StudentController::class, 'getAllClasses']);
        Route::get('/class/{id}', [\App\Http\Controllers\StudentController::class, 'getClass']);
        Route::post('/class/join-student', [\App\Http\Controllers\StudentController::class, 'joinStudent']);
        Route::delete('/class/leave/{classroom_id}', [\App\Http\Controllers\StudentController::class, 'leaveClass']);
    });

    Route::get("/assignment/{assignment_id}",[\App\Http\Controllers\AssignmentController::class, 'show']);

});

Route::apiResource('classroom', \App\Http\Controllers\ClassroomController::class);
Route::apiResource('workout', \App\Http\Controllers\WorkoutController::class);


