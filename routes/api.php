<?php

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckModuleActive;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/modules', [ModuleController::class, 'index'])->middleware('auth:sanctum');

Route::post('/modules/{id}/activate', [UserController::class, 'activateUserModule'])->middleware('auth:sanctum');
Route::post('/modules/{id}/deactivate', [UserController::class, 'deactivateUserModule'])->middleware('auth:sanctum');


Route::get('/links', [ShortUrlController::class, 'index'])->middleware('auth:sanctum', CheckModuleActive::class);
Route::post('/shorten', [ShortUrlController::class, 'store'])->middleware('auth:sanctum', CheckModuleActive::class);
Route::get('/s/{code}', [ShortUrlController::class, 'goToOriginal'])->middleware(CheckModuleActive::class);


