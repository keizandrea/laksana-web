<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Jalur Masuk API SPA (React)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Dibungkus oleh kunci Bearer Token Sanctum
Route::middleware('auth:sanctum')->group(function () {
    
    // Ambil data user saat modal kebuka
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Jalur resmi update profil lewat API
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
    
    Route::post('/logout', [AuthController::class, 'logout']);
});