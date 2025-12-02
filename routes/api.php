<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('tasks', [TaskController::class, 'index']);
Route::get('task/{id}', [TaskController::class, 'getTask']);
Route::post('tasks', [TaskController::class, 'store']);
Route::put('task/{id}', [TaskController::class, 'update']);
Route::delete('task/{id}', [TaskController::class, 'delete']);

Route::apiResource('tasks', TaskController::class);


Route::post('profile', [ProfileController::class, 'store']);
Route::get('profile/users/{id}', [ProfileController::class, 'show']);
Route::get('profile/{id}', [ProfileController::class, 'showProfile']);
Route::put('profile/{id}', [ProfileController::class, 'edite']);

Route::get('user/{id}/tasks', [TaskController::class, 'getUserTasks']);
Route::get('task/{id}/user', [UserController::class, 'getTasksUser']);

Route::post('category', [CategoryController::class, 'store']);
Route::get('category/{catID}/tasks' , [CategoryController::class , 'getCategoriesTask']);
Route::post('task/{taskId}/categories', [TaskController::class, 'addCategoriesToTask']);
Route::get('task/{taskId}/categories', [CategoryController::class, 'getTaskCategories']);
