<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Role;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    // 🟢 Registro de usuario + doctor + rol
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'dni'      => 'required|digits:8|unique:doctors,dni',
            'name'     => 'required|string',
            'role'     => 'required|string|in:admin,dentista,clinico',
        ]);

        // Crear usuario
        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Crear doctor
        $doctor = Doctor::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'dni'     => $request->dni,
            'user_id' => $user->id,
        ]);

        // Asignar rol
        $role = Role::firstOrCreate(
            ['name' => $request->role],
            ['description' => ucfirst($request->role)]
        );

        $doctor->roles()->attach($role->id);

        return response()->json(['message' => 'Usuario registrado correctamente'], 201);
    }

    // 🔐 Login con username o email
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string', // puede ser username o email
            'password' => 'required|string',
        ]);

        // Buscar por username o email
        $user = User::where('email', $request->login)
                    ->orWhere('username', $request->login)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        // Obtener doctor vinculado
        $doctor = $user->doctor;

        if (!$doctor) {
            return response()->json(['message' => 'Usuario sin perfil de doctor.'], 403);
        }

        // Crear token personalizado
        $tokenString = Str::random(64);
        $token = new Token([
            'token'      => $tokenString,
            'expires_at' => Carbon::now()->addHours(6),
        ]);
        $doctor->tokens()->save($token);

        return response()->json([
            'token'  => $tokenString,
            'doctor' => $doctor,
            'roles'  => $doctor->roles->pluck('name'),
        ]);
    }

    // 🔒 Logout → eliminar token actual
    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if ($token) {
            Token::where('token', $token)->delete();
        }

        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }
}
