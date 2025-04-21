<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PatientController,
    TratamientoController,
    HistorialClinicoController,
    PlanTratamientoController,
    AuthController
};

// Autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Pacientes
Route::get('/patients', [PatientController::class, 'index']);
Route::post('/patients', [PatientController::class, 'store']);
Route::get('/patients/{id}', [PatientController::class, 'show']);
Route::put('/patients/{id}', [PatientController::class, 'update']);
Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

// Tratamientos por paciente
Route::get('/patients/{id}/tratamientos', [TratamientoController::class, 'index']);
Route::post('/tratamientos', [TratamientoController::class, 'store']);

// Historial clínico
Route::get('/patients/{id}/historial', [HistorialClinicoController::class, 'show']);
Route::post('/historial', [HistorialClinicoController::class, 'storeOrUpdate']);

// Planes de tratamiento
Route::get('/patients/{id}/planes', [PlanTratamientoController::class, 'index']);
Route::post('/planes', [PlanTratamientoController::class, 'store']);
