<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        return Patient::with(['historialClinico', 'tratamientos', 'planesTratamiento'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'apellido' => 'required|string',
            'nombre' => 'required|string',
            'dni' => 'required|digits:8|unique:patients,dni',
            'sexo' => 'required|string|in:masculino,femenino,otro',
            'fecha_nacimiento' => 'nullable|date',
            'obra_social' => 'nullable|string',
            'afiliado_nro' => 'nullable|string',
            'parentesco' => 'nullable|string',
            'titular' => 'nullable|string',
            'domicilio' => 'nullable|string',
            'telefono' => 'nullable|string',
            'servicio' => 'nullable|string',
        ]);

        $patient = Patient::create($request->all());

        return response()->json($patient, 201);
    }

    public function show($id)
    {
        return Patient::with(['historialClinico', 'tratamientos', 'planesTratamiento'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());
        return response()->json($patient);
    }

    public function destroy($id)
    {
        Patient::destroy($id);
        return response()->json(['message' => 'Paciente eliminado']);
    }
}
