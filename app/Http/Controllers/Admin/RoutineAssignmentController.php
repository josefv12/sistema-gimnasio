<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsignacionRutinaCliente;
use App\Models\Cliente;
use App\Models\Rutina;
use App\Models\Entrenador;
use Illuminate\Support\Facades\Auth;

class RoutineAssignmentController extends Controller
{
    public function index()
    {
        $assignments = AsignacionRutinaCliente::with(['cliente', 'rutina', 'entrenador'])
            ->orderBy('fecha_asignacion', 'desc')
            ->paginate(10);
        return view('admin.routine_assignments.index', compact('assignments'));
    }

    public function create()
    {
        $clients = Cliente::orderBy('nombre')->get();
        $routines = Rutina::orderBy('nombre')->get();
        $trainers = Entrenador::orderBy('nombre')->get();
        return view('admin.routine_assignments.create', compact('clients', 'routines', 'trainers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_cliente' => 'required|exists:Cliente,id_cliente',
            'id_rutina' => 'required|exists:Rutina,id_rutina',
            'id_entrenador' => 'nullable|exists:Entrenador,id_entrenador',
            'fecha_asignacion' => 'required|date',
            'estado' => 'required|string|in:activa,completada,cancelada',
            'notas_entrenador' => 'nullable|string',
        ], [
            'id_cliente.required' => 'El campo cliente es obligatorio.',
            'id_cliente.exists' => 'El cliente seleccionado no es válido.',
            'id_rutina.required' => 'El campo rutina es obligatorio.',
            'id_rutina.exists' => 'La rutina seleccionada no es válida.',
            'id_entrenador.exists' => 'El entrenador seleccionado no es válido.',
            'fecha_asignacion.required' => 'La fecha de asignación es obligatoria.',
            'estado.required' => 'El estado de la asignación es obligatorio.',
        ]);

        if (isset($validatedData['id_entrenador']) && $validatedData['id_entrenador'] === '') {
            $validatedData['id_entrenador'] = null;
        }

        AsignacionRutinaCliente::create($validatedData);

        return redirect()->route('admin.routine_assignments.index')
            ->with('success', '¡Rutina asignada al cliente exitosamente!');
    }

    public function edit(AsignacionRutinaCliente $asignacionRutinaCliente)
    {
        $clients = Cliente::orderBy('nombre')->get();
        $routines = Rutina::orderBy('nombre')->get();
        $trainers = Entrenador::orderBy('nombre')->get();
        $assignment = $asignacionRutinaCliente;
        return view('admin.routine_assignments.edit', compact('assignment', 'clients', 'routines', 'trainers'));
    }

    public function update(Request $request, AsignacionRutinaCliente $asignacionRutinaCliente)
    {
        $validatedData = $request->validate([
            'id_entrenador' => 'nullable|exists:Entrenador,id_entrenador',
            'fecha_asignacion' => 'required|date',
            'estado' => 'required|string|in:activa,completada,cancelada',
            'notas_entrenador' => 'nullable|string',
        ], [
            'id_entrenador.exists' => 'El entrenador seleccionado no es válido.',
            'fecha_asignacion.required' => 'La fecha de asignación es obligatoria.',
            'estado.required' => 'El estado de la asignación es obligatorio.',
        ]);

        if (array_key_exists('id_entrenador', $validatedData) && $validatedData['id_entrenador'] === '') {
            $validatedData['id_entrenador'] = null;
        }

        $asignacionRutinaCliente->update($validatedData);

        return redirect()->route('admin.routine_assignments.index')
            ->with('success', '¡Asignación de rutina actualizada exitosamente!');
    }

    /**
     * Elimina una asignación de rutina específica de la base de datos.
     *
     * @param  \App\Models\AsignacionRutinaCliente  $asignacionRutinaCliente
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AsignacionRutinaCliente $asignacionRutinaCliente)
    {
        try {
            $asignacionRutinaCliente->delete();

            return redirect()->route('admin.routine_assignments.index')
                ->with('success', '¡Asignación de rutina eliminada exitosamente!');
        } catch (\Exception $e) {
            // En este caso, una asignación simple no suele tener dependencias que impidan su borrado directo
            // a menos que otras tablas dependan de 'id_asignacion'.
            // Un QueryException podría ocurrir por otras razones, pero es menos probable que sea por FK.
            return redirect()->route('admin.routine_assignments.index')
                ->with('error', 'Ocurrió un error al intentar eliminar la asignación: ' . $e->getMessage());
        }
    }
}