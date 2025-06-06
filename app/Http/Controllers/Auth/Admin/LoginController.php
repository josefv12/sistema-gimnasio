<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException; // Para manejar errores de validación/login

class LoginController extends Controller
{
    /**
     * Muestra el formulario de login para el administrador.
     */
    public function showLoginForm()
    {
        // Antes de mostrar el formulario, verifica si el admin ya está logueado
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard'); // Redirige al dashboard si ya está logueado
        }
        return view('auth.admin.login'); // Crea esta vista: resources/views/auth/admin/login.blade.php
    }

    /**
     * Maneja la petición de login para el administrador.
     */
    public function login(Request $request)
    {
        // 1. Validar los datos del formulario
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required|string',
        ]);

        // 2. Intentar autenticar usando el guard 'admin'
        //    Asegúrate de que el campo 'correo' en tu tabla Administrador es el que usas para login.
        if (Auth::guard('admin')->attempt(['correo' => $request->correo, 'password' => $request->password], $request->filled('remember'))) {
            // 3. Si la autenticación es exitosa:
            $request->session()->regenerate(); // Regenera la sesión para prevenir session fixation
            return redirect()->intended(route('admin.dashboard')); // Redirige al dashboard del admin o a la ruta intentada
        }

        // 4. Si la autenticación falla:
        //    Lanza una excepción de validación para mostrar el error.
        throw ValidationException::withMessages([
            'correo' => [trans('auth.failed')], // Mensaje de error estándar de Laravel
        ]);
    }

    /**
     * Maneja la petición de logout para el administrador.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // Cierra la sesión del guard 'admin'

        $request->session()->invalidate(); // Invalida la sesión actual
        $request->session()->regenerateToken(); // Regenera el token CSRF

        return redirect()->route('admin.login'); // Redirige al formulario de login del admin
    }

    /**
     * Define la ruta a la que redirigir después del login si no hay 'intended'.
     * (Este método es opcional si siempre usas intended() o una ruta específica)
     */
    // protected function redirectTo()
    // {
    //     return route('admin.dashboard');
    // }

    /**
     * Constructor - Aplicar middleware 'guest' para el guard 'admin'
     * excepto para el método 'logout'.
     */
    public function __construct()
    {
        // Este middleware asegura que un administrador ya logueado no pueda acceder
        // a la página de login nuevamente, redirigiéndolo si lo intenta.
        // Se aplica al guard 'admin'.
        $this->middleware('guest:admin')->except('logout');
    }
}
