<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar los campos del formulario con las reglas definidas en validation.php
        $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/u|max:255', // Solo letras y espacios
            'email' => 'required|string|email|max:255|unique:users,email', // Validación de formato de correo y unicidad
            'password' => 'required|confirmed|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[@$!%*#?&]/|regex:/[0-9]/', // Requisitos de la contraseña
        ]);

        // Crear el usuario con los datos del formulario y rol predeterminado 'alumno'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_ALUMNO, // Asignar rol 'alumno' por defecto
        ]);

        // Desencadenar el evento de registro
        event(new Registered($user));

        // Redirigir a la misma página de registro con un mensaje de éxito
        return redirect()->route('register')->with('success', 'Usuario registrado con éxito.');
    }
}
