<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\SectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    // Защищенные маршруты
//    Route::get('/users', [UserController::class, 'index']);
//    Route::put('/users/update-accesses', [UserController::class, 'updateAccesses']);
//    Route::delete('/teacher/delete/{id}', [TeacherController::class, 'delete_teacher']);
    Route::get('/all_languages', [LanguageController::class, 'index']);
    Route::delete('/language_delete/{id}', [LanguageController::class, 'destroy']);
    Route::post('/languages_add', [LanguageController::class, 'store']);
    Route::get('/all_sections', [SectionController::class, 'index']);
    Route::delete('/section_delete/{id}', [SectionController::class, 'destroy']);
    Route::post('/section_add', [SectionController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/exercises', [ExerciseController::class, 'getThemes']);
});
Route::post('register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

