<?php

namespace App\Http\Controllers;

use App\Models\HistorialClinico;
use Illuminate\Http\Request;

class HistorialClinicoController extends Controller
{
    public function show($patient_id)
    {
        return HistorialClinico::where('patient_id', $patient_id)->first();
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'primera_consulta' => 'nullable|date',
            'bajo_atencion_medica' => 'boolean',
            'enfermedad_grave' => 'boolean',
            'enfermedades' => 'nullable|array',
            'medicacion' => 'boolean',
            'cual_medicacion' => 'nullable|string',
            'aspirinas' => 'boolean',
            'embarazo' => 'nullable|boolean',
            'problemas_dentales_previos' => 'boolean',
            'fuma' => 'boolean',
            'observaciones' => 'nullable|string',
        ]);

        $historial = HistorialClinico::updateOrCreate(
            ['patient_id' => $request->patient_id],
            $request->all()
        );

        return response()->json($historial);
    }
}
