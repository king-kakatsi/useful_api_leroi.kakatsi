<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/modules', [UserController::class, 'register'])->middleware('auth:sanctum');

Route::post('/modules/:id/activate', [UserController::class, 'register'])->middleware('auth:sanctum');
Route::post('/modules/:id/deactivate', [UserController::class, 'register'])->middleware('auth:sanctum');
// Route::get('/register', [UserController::class, 'register']);
