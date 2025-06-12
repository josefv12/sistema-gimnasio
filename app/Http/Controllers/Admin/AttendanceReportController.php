<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asistencia;

class AttendanceReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Asistencia::with('cliente')->latest(); // Carga el cliente y ordena por más reciente

        // Filtro de búsqueda por fecha
        if ($request->filled('fecha_busqueda')) {
            $query->whereDate('hora_entrada', $request->input('fecha_busqueda'));
        }

        $asistencias = $query->paginate(20);

        return view('admin.reports.attendance', compact('asistencias'));
    }
}