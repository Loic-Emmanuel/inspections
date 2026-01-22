<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InspectionController;
use App\Models\User;

// Routes publiques
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/users', function () {
    return User::all();
});

// Routes protégées par Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::apiResource('inspections', InspectionController::class);
});

