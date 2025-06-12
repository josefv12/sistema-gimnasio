<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Rutina;
use App\Models\AsignacionRutinaCliente;
use App\Models\Ejercicio;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
// No es estrictamente necesario importar RutinaEjercicio aquí,
// pero es buena práctica si interactúas con él directamente.
use App\Models\RutinaEjercicio;

class ClientRoutineController extends Controller
{
    /**
     * Muestra la página de gestión de rutina para un cliente específico.
     */
    public function index(Cliente $cliente)
    {
        // 1. Buscar la asignación de rutina activa para este cliente
        $asignacionActiva = AsignacionRutinaCliente::where('id_cliente', $cliente->id_cliente)
            ->where('estado', 'activa')
            ->with('rutina.rutinaEjercicios.ejercicio') // Cargar relaciones anidadas
            ->first();

        // 2. Obtener todos los ejercicios disponibles para añadirlos a la rutina
        $ejerciciosDisponibles = Ejercicio::orderBy('nombre', 'asc')->get();

        // 3. Pasar todos los datos a la vista
        return view('trainer.my_clients.routine.index', compact('cliente', 'asignacionActiva', 'ejerciciosDisponibles'));
    }

    /**
     * Crea una nueva rutina y la asigna al cliente.
     */
    public function store(Request $request, Cliente $cliente)
    {
        $request->validate(['nombre_rutina' => 'required|string|max:255']);
        $trainerId = Auth::guard('trainer')->id();

        $nuevaRutina = Rutina::create([
            'nombre' => $request->input('nombre_rutina'),
            'id_entrenador' => $trainerId,
            'descripcion' => 'Rutina personalizada para ' . $cliente->nombre,
        ]);

        AsignacionRutinaCliente::where('id_cliente', $cliente->id_cliente)
            ->where('estado', 'activa')
            ->update(['estado' => 'inactiva']);

        AsignacionRutinaCliente::create([
            'id_rutina' => $nuevaRutina->id_rutina,
            'id_cliente' => $cliente->id_cliente,
            'id_entrenador' => $trainerId,
            'fecha_asignacion' => Carbon::today(),
            'estado' => 'activa',
        ]);

        return redirect()->route('trainer.clients.routine.index', $cliente->id_cliente)
            ->with('success', '¡Rutina creada y asignada exitosamente!');
    }

    // ===== INICIO DE LA MODIFICACIÓN =====
    /**
     * Añade un ejercicio a una rutina existente.
     */
    public function addExercise(Request $request, Rutina $rutina)
    {
        // 1. Validar los datos del formulario del modal
        $validatedData = $request->validate([
            'id_ejercicio' => 'required|exists:Ejercicio,id_ejercicio',
            'series' => 'required|string|max:50',
            'repeticiones' => 'required|string|max:50',
            'duracion_segundos' => 'nullable|integer',
            'descanso_segundos' => 'nullable|integer',
            'notas' => 'nullable|string',
        ]);

        // 2. Usar el método de relación 'attach' para crear el registro en la tabla pivote
        // El método 'attach' es ideal para relaciones muchos-a-muchos.
        $rutina->ejercicios()->attach($validatedData['id_ejercicio'], [
            'series' => $validatedData['series'],
            'repeticiones' => $validatedData['repeticiones'],
            'duracion' => $validatedData['duracion_segundos'],
            'descanso' => $validatedData['descanso_segundos'],
            'notas' => $validatedData['notas'],
        ]);

        // 3. Redirigir de vuelta con un mensaje de éxito.
        return back()->with('success', '¡Ejercicio añadido a la rutina exitosamente!');
    }
    // ===== FIN DE LA MODIFICACIÓN =====
}