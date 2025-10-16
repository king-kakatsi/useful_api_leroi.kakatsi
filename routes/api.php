<?php

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckModuleActive;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/modules', [ModuleController::class, 'index'])->middleware('auth:sanctum');

Route::post('/modules/{id}/activate', [UserController::class, 'activateUserModule'])->middleware('auth:sanctum');
Route::post('/modules/{id}/deactivate', [UserController::class, 'deactivateUserModule'])->middleware('auth:sanctum');
// Route::post('/modules/{id}/deactivate', [UserController::class, 'deactivateUserModule'])->middleware('auth:sanctum', CheckModuleActive::class);
