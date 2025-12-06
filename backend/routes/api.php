<?php

use App\Http\Controllers\Api\Admin\HouseOwnerController;
use App\Http\Controllers\Api\Admin\TenantController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HouseOwner\BillCategoryController;
use App\Http\Controllers\Api\HouseOwner\BillController;
use App\Http\Controllers\Api\HouseOwner\FlatController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('jwt.auth')->group(function () {

    // Admin Routes
    Route::prefix('admin')->middleware('can:admin')->group(function () {
        Route::apiResource('house-owners', HouseOwnerController::class);
        Route::apiResource('tenants', TenantController::class);
        Route::post('tenants/{tenant}/assign', [TenantController::class, 'assign']);
    });

    // House Owner Routes
    Route::prefix('owner')->middleware('can:house_owner')->group(function () {
        Route::apiResource('flats', FlatController::class);
        Route::apiResource('bill-categories', BillCategoryController::class);
        Route::apiResource('bills', BillController::class);
        Route::patch('bills/{bill}/status', [BillController::class, 'updateStatus']);
    });

});
