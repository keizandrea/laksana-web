<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReportController;

// Route Publik (Bebas Akses)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Route Terproteksi Sesi (Wajib Token Valid)
Route::middleware('auth:sanctum')->group(function () {
    
    // Ambil data user yang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Fitur Manajemen Laporan Kelompokmu
    Route::post('/reports', [ReportController::class, 'store']); 
    Route::get('/reports', [ReportController::class, 'index']);
    Route::get('/my-reports', [ReportController::class, 'myReports']);
    Route::put('/reports/{id}/status', [ReportController::class, 'updateStatus']);
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});