<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

// Create
Route::post('/todo', [TodoController::class, 'store']);
// Read
Route::get('/todo/{id}', [TodoController::class, 'show']);

Route::get('/todo', [TodoController::class, 'index']);

// Update
Route::put('/todo/{id}', [TodoController::class, 'update']);
// Delete
Route::delete('/todo/{id}', [TodoController::class, 'destroy']);