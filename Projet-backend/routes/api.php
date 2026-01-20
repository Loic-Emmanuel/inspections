<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InspectionController;


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('inspections', InspectionController::class);
});

