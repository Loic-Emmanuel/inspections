<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\InspectionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ReportController;

$registerRoutes = function () {
    // Authentification publique
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Routes protégées par Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        // Authentification & profil
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/update/profile', [ProfileController::class, 'update']);

        // Dashboard & Statistiques
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::get('/stat/month', [DashboardController::class, 'statMonth']);

        // Inspections
        Route::get('/list/inspections', [InspectionController::class, 'index']);
        Route::post('/store/inspections', [InspectionController::class, 'store']);
        Route::get('/show/inspection/{id}', [InspectionController::class, 'show']);
        Route::apiResource('inspections', InspectionController::class);

        // Rapports PDF
        Route::get('/inspections/{id}/report', [ReportController::class, 'generate']);
        Route::get('/inspections/{id}/report/download', [ReportController::class, 'download']);

        // Clients
        Route::get('/clients', [ClientController::class, 'index']);
        Route::post('/clients', [ClientController::class, 'store']);

        // Gestion des utilisateurs
        Route::get('/list/users', [UserController::class, 'index']);
        Route::post('/register', [UserController::class, 'store']);
        Route::post('/update/{id}', [UserController::class, 'update']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy']);
    });
};

// Enregistrement sous /v1/ et à la racine de l'API
Route::prefix('v1')->group($registerRoutes);
$registerRoutes();
