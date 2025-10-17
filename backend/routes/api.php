<?php

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckModuleActive;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/users', [UserController::class, 'index']);

Route::get('/modules', [ModuleController::class, 'index'])->middleware('auth:sanctum');

Route::post('/modules/{id}/activate', [UserController::class, 'activateUserModule'])->middleware('auth:sanctum');
Route::post('/modules/{id}/deactivate', [UserController::class, 'deactivateUserModule'])->middleware('auth:sanctum');


Route::group(['middleware' => ['auth', 'web']], function() {
  // uses 'auth' middleware plus all middleware from $middlewareGroups['web']
  Route::resource('blog','BlogController'); //Make a CRUD controller
});

// Route::get('/links', [ShortUrlController::class, 'index'])->middleware('auth:sanctum', CheckModuleActive::class);
Route::get('/links', [ShortUrlController::class, 'index'])->middleware('auth:sanctum')->middleware([CheckModuleActive::class, 1]);
Route::post('/shorten', [ShortUrlController::class, 'store'])->middleware('auth:sanctum')->middleware([CheckModuleActive::class, 1]);
Route::get('/s/{code}', [ShortUrlController::class, 'goToOriginal'])->middleware([CheckModuleActive::class, 1]);
// Route::get('/links/{id}', [ShortUrlController::class, 'destroy'])->middleware('auth:sanctum', CheckModuleActive::class);
Route::get('/links/{id}', [ShortUrlController::class, 'destroy'])->middleware('auth:sanctum')->middleware([CheckModuleActive::class, 1]);


