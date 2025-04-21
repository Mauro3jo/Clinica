<?php

namespace App\Http\Controllers;

use App\Models\Tratamiento;
use Illuminate\Http\Request;

class TratamientoController extends Controller
{
    public function index($patient_id)
    {
        return Tratamiento::where('patient_id', $patient_id)->with('doctor')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'fecha' => 'required|date',
            'codigo' => 'nullable|string',
            'pieza_dental' => 'nullable|string',
            'ubicacion_lesion' => 'nullable|string',
            'arancel' => 'nullable|numeric',
            'pago' => 'nullable|numeric',
            'debe' => 'nullable|numeric',
            'saldo' => 'nullable|numeric',
            'conducta_rx' => 'nullable|string',
            'trabajo_realizado' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $tratamiento = Tratamiento::create($request->all());

        return response()->json($tratamiento, 201);
    }
}
