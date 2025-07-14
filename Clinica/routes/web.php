<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    PatientController,
    TratamientoController,
    HistorialClinicoController,
    PlanTratamientoController
};
use App\Http\Controllers\DemoLinkPagoController;

// AUTENTICACIÓN
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// PACIENTES
Route::get('/patients', [PatientController::class, 'index']);
Route::post('/patients', [PatientController::class, 'store']);
Route::get('/patients/{id}', [PatientController::class, 'show']);
Route::put('/patients/{id}', [PatientController::class, 'update']);
Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

// TRATAMIENTOS
Route::get('/patients/{id}/tratamientos', [TratamientoController::class, 'index']);
Route::post('/tratamientos', [TratamientoController::class, 'store']);

// HISTORIAL CLÍNICO
Route::get('/patients/{id}/historial', [HistorialClinicoController::class, 'show']);
Route::post('/historial', [HistorialClinicoController::class, 'storeOrUpdate']);

// PLANES DE TRATAMIENTO
Route::get('/patients/{id}/planes', [PlanTratamientoController::class, 'index']);
Route::post('/planes', [PlanTratamientoController::class, 'store']);

// ---------- DEMO LINK DE PAGO ----------
Route::post('/demo-link-pago', [DemoLinkPagoController::class, 'pagar']);

// SPA (Vue) - fallback (¡SIEMPRE debe estar al final!)
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
