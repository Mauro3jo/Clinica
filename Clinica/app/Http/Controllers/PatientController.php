<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Trae todos los pacientes con relaciones
    public function index()
    {
        $patients = Patient::all();
        return response()->json($patients);
    }

    // Crear nuevo paciente
    public function store(Request $request)
    {
        $request->validate([
            'apellido' => 'required|string',
            'nombre' => 'required|string',
            'dni' => 'required|digits:8|unique:patients,dni',
            'sexo' => 'required|string|in:masculino,femenino,otro',
            'edad' => 'nullable|integer',
            'fecha_nacimiento' => 'nullable|date',
            'obra_social' => 'nullable|string',
            'codigo_obra_social' => 'nullable|string',
            'afiliado_nro' => 'nullable|string',
            'parentesco' => 'nullable|string',
            'titular' => 'nullable|string',
            'domicilio' => 'nullable|string',
            'localidad' => 'nullable|string',
            'telefono' => 'nullable|string',
            'servicio' => 'nullable|string',
            'fecha_primera_consulta' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        $patient = Patient::create($request->all());

        return response()->json($patient, 201);
    }

    // Mostrar detalle de un paciente
    public function show($id)
    {
        $patient = Patient::with(['historialClinico', 'tratamientos', 'planesTratamiento'])->find($id);

        if (!$patient) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }

        return response()->json($patient);
    }

    // Actualizar paciente
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());

        return response()->json($patient);
    }

    // Eliminar paciente
    public function destroy($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }

        $patient->delete();

        return response()->json(['message' => 'Paciente eliminado correctamente']);
    }
}
