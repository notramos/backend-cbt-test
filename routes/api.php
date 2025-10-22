<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\ExamSessionController;

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the application!']);
});

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/exams', [ExamController::class, 'index']);
    Route::get('/exams/{id}/start', [ExamSessionController::class, 'start']);
    Route::post('/exam-sessions/{id}/submit', [ExamSessionController::class, 'submit']);
    Route::get('/exam-sessions/{id}', [ExamSessionController::class, 'show']);
    Route::get('/exam-sessions/{id}/review', [ExamSessionController::class, 'review']);
});
