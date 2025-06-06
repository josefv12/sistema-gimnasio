<?php

namespace App\Http\Controllers\Auth\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct()
    {
        // Middleware 'guest' para el guard 'trainer', excepto para 'logout'.
        $this->middleware('guest:trainer')->except('logout');
    }

    /**
     * Muestra el formulario de login para el entrenador.
     */
    public function showLoginForm()
    {
        return view('auth.trainer.login'); // Vista en: resources/views/auth/trainer/login.blade.php
    }

    /**
     * Maneja la petición de login para el entrenador.
     */
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('trainer')->attempt(['correo' => $request->correo, 'password' => $request->password], $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('trainer.dashboard')); // Redirige al dashboard del entrenador
        }

        throw ValidationException::withMessages([
            'correo' => [trans('auth.failed')],
        ]);
    }

    /**
     * Maneja la petición de logout para el entrenador.
     */
    public function logout(Request $request)
    {
        Auth::guard('trainer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('trainer.login'); // Redirige al login del entrenador
    }
}