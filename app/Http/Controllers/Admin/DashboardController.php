<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // Aunque no se use en este método, es común tenerla
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // El middleware 'auth:admin' en las rutas ya protege este método.
        $user = Auth::guard('admin')->user();

        // Es buena práctica verificar si el usuario existe, aunque el middleware debería garantizarlo.
        if (!$user) {
            // Esto es una doble seguridad, el middleware debería haber redirigido ya.
            return redirect()->route('admin.login');
        }

        // Pasamos la variable 'userName' a la vista
        return view('admin.dashboard', ['userName' => $user->nombre]);
    }
}