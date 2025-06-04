<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::prefix('departments')->group(function () {
    Route::get('/', [DepartmentController::class, 'index']);
    Route::post('/store', [DepartmentController::class, 'store']);
    Route::get('{department}', [DepartmentController::class, 'show']);
    Route::put('{department}', [DepartmentController::class, 'update']);
    Route::delete('{department}', [DepartmentController::class, 'destroy']);
});

Route::prefix('staffs')->group(function () {
    Route::get('/', [StaffController::class, 'index']);
    Route::get('/departments', [StaffController::class, 'departments']);
    Route::get('/{staff}', [StaffController::class, 'show']);
    Route::post('/', [StaffController::class, 'store']);
    Route::put('/{staff}', [StaffController::class, 'update']);
    Route::delete('/{staff}', [StaffController::class, 'destroy']);
});
