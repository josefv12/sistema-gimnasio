<?php

namespace App\Http\Controllers\Auth\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct()
    {
        // Middleware 'guest' para el guard 'web'.
        // 'web' es el guard por defecto si no se especifica uno y está configurado para clientes.
        $this->middleware('guest:web')->except('logout');
    }

    /**
     * Muestra el formulario de login para el cliente.
     */
    public function showLoginForm()
    {
        // El middleware 'guest:web' ya se encarga de redirigir si está logueado.
        return view('auth.client.login'); // Vista en: resources/views/auth/client/login.blade.php
    }

    /**
     * Maneja la petición de login para el cliente.
     */
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required|string',
        ]);

        // Usamos el guard 'web' (configurado para el provider 'clientes')
        if (Auth::guard('web')->attempt(['correo' => $request->correo, 'password' => $request->password], $request->filled('remember'))) {
            $request->session()->regenerate();
            // Redirige al dashboard del cliente. Asegúrate que la ruta 'client.dashboard' exista.
            return redirect()->intended(route('client.dashboard'));
        }

        throw ValidationException::withMessages([
            'correo' => [trans('auth.failed')],
        ]);
    }

    /**
     * Maneja la petición de logout para el cliente.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // Cierra la sesión del guard 'web'
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Redirige al login del cliente. Asegúrate que la ruta 'client.login' exista.
        return redirect()->route('client.login');
    }
}