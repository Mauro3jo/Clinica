<?php

namespace App\Http\Controllers;

use App\Models\PlanTratamiento;
use Illuminate\Http\Request;

class PlanTratamientoController extends Controller
{
    public function index($patient_id)
    {
        return PlanTratamiento::where('patient_id', $patient_id)->with('doctor')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'fecha' => 'required|date',
            'dientes_afectados' => 'nullable|array',
            'referencias' => 'nullable|array',
            'tratamientos_previos' => 'nullable|array',
            'tratamientos_propuestos' => 'nullable|array',
            'firma' => 'nullable|string',
        ]);

        $plan = PlanTratamiento::create($request->all());

        return response()->json($plan, 201);
    }
}
