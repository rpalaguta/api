<?php

// routes/api.php
if (app()->environment('testing')) {
    Route::apiResource('psychologists', PsychologistController::class);
    Route::apiResource('psychologists.time-slots', TimeSlotController::class);
    Route::apiResource('appointments', AppointmentController::class);
} else {
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('psychologists', PsychologistController::class);
        Route::apiResource('psychologists.time-slots', TimeSlotController::class);
        Route::apiResource('appointments', AppointmentController::class);
    });
}
