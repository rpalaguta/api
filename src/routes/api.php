<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PsychologistController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;

Route::prefix('psychologist')->group(function () {
    Route::prefix('{psychologist_id}')->group(function () {
        Route::prefix('time-slots')->group(function () {
            Route::get('', [TimeSlotController::class, 'index']);
            Route::middleware('auth:sanctum')->group(function () {
                Route::post('', [TimeSlotController::class, 'store']);
                Route::put('{time_slot_id}', [TimeSlotController::class, 'update']);
                Route::delete('{time_slot_id}', [TimeSlotController::class, 'destroy']);
            });
        });
    });
});

Route::get('appointments', [TimeSlotController::class, 'listAppointments']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('reserve/{time_slot_id}', [TimeSlotController::class, 'reserve']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');
