<?php

use App\Http\Controllers\AudioUploadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\VideoUploadController;
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
    Route::delete('/language_delete/{id}', [LanguageController::class, 'destroy']);
    Route::post('/languages_add', [LanguageController::class, 'store']);
    Route::delete('/section_delete/{id}', [SectionController::class, 'destroy']);
    Route::post('/section_add', [SectionController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/exercises_create', [ExerciseController::class, 'create']);
    Route::get('/exercises_check_theme', [ExerciseController::class, 'checkIfThemeExists']);
    Route::post('/add-exercise', [ExerciseController::class, 'addExercise']);
    Route::post('/delete-exercises', [ExerciseController::class, 'deleteExercises']);
    Route::post('/delete-task-exercise', [ExerciseController::class, 'deleteTaskExercise']);
    Route::post('/upload-video', [VideoUploadController::class, 'upload']);
    Route::post('/upload-image', [ImageUploadController::class, 'upload']);
    Route::post('/upload-audio', [AudioUploadController::class, 'upload']);
    Route::put('/update-exercise', [ExerciseController::class, 'updateExercise']);

});
Route::get('/get-exercises', [ExerciseController::class, 'getExercises']);
Route::get('/exercises', [ExerciseController::class, 'getThemes']);
Route::get('/all_languages', [LanguageController::class, 'index']);
Route::get('/all_sections', [SectionController::class, 'index']);
Route::post('register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

