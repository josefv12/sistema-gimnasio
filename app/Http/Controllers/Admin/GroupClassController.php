<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClaseGrupal;
use App\Models\Entrenador;
use App\Models\ClienteClaseReserva; // <-- AÑADIR IMPORTACIÓN
// use Illuminate\Validation\Rule;

class GroupClassController extends Controller
{
    // ... (métodos index, create, store, edit, update, destroy, show existentes) ...
    public function index()
    {
        $groupClasses = ClaseGrupal::with('entrenador')
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_inicio', 'asc')
            ->paginate(10);
        return view('admin.group_classes.index', compact('groupClasses'));
    }

    public function create()
    {
        $trainers = Entrenador::orderBy('nombre')->get();
        return view('admin.group_classes.create', compact('trainers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio',
            'cupo_maximo' => 'required|integer|min:1',
            'id_entrenador' => 'nullable|exists:Entrenador,id_entrenador',
            'estado' => 'required|string|in:programada,confirmada,cancelada,realizada',
        ], [
            'fecha.after_or_equal' => 'La fecha de la clase no puede ser anterior a hoy.',
            'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.'
        ]);

        if (isset($validatedData['id_entrenador']) && $validatedData['id_entrenador'] === '') {
            $validatedData['id_entrenador'] = null;
        }

        if (empty($validatedData['hora_fin'])) {
            $validatedData['hora_fin'] = null;
        }

        ClaseGrupal::create($validatedData);

        return redirect()->route('admin.group_classes.index')
            ->with('success', '¡Clase grupal creada exitosamente!');
    }

    public function show(ClaseGrupal $claseGrupal)
    {
        $claseGrupal->load(['clienteClaseReservas.cliente', 'entrenador']);
        $cuposOcupados = $claseGrupal->clienteClaseReservas->where('estado', 'confirmada')->count();
        $cuposDisponibles = $claseGrupal->cupo_maximo - $cuposOcupados;
        return view('admin.group_classes.show', compact('claseGrupal', 'cuposOcupados', 'cuposDisponibles'));
    }

    public function edit(ClaseGrupal $claseGrupal)
    {
        $trainers = Entrenador::orderBy('nombre')->get();
        return view('admin.group_classes.edit', compact('claseGrupal', 'trainers'));
    }

    public function update(Request $request, ClaseGrupal $claseGrupal)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio',
            'cupo_maximo' => 'required|integer|min:1',
            'id_entrenador' => 'nullable|exists:Entrenador,id_entrenador',
            'estado' => 'required|string|in:programada,confirmada,cancelada,realizada',
        ], [
            'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.'
        ]);

        if (array_key_exists('id_entrenador', $validatedData) && $validatedData['id_entrenador'] === '') {
            $validatedData['id_entrenador'] = null;
        }
        if (empty($validatedData['hora_fin'])) {
            $validatedData['hora_fin'] = null;
        }

        $claseGrupal->update($validatedData);

        return redirect()->route('admin.group_classes.index')
            ->with('success', '¡Clase grupal actualizada exitosamente!');
    }

    public function destroy(ClaseGrupal $claseGrupal)
    {
        try {
            $claseGrupal->delete();
            return redirect()->route('admin.group_classes.index')
                ->with('success', '¡Clase grupal eliminada exitosamente!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000' || str_contains($e->getMessage(), 'constraint violation')) {
                return redirect()->route('admin.group_classes.index')
                    ->with('error', 'No se pudo eliminar la clase grupal. Es posible que tenga reservas o asistencias asociadas.');
            }
            return redirect()->route('admin.group_classes.index')
                ->with('error', 'Error al eliminar la clase grupal: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('admin.group_classes.index')
                ->with('error', 'Ocurrió un error inesperado al intentar eliminar la clase grupal.');
        }
    }

    /**
     * Marca la asistencia para una reserva de clase grupal específica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClienteClaseReserva  $clienteClaseReserva
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAttendance(Request $request, ClienteClaseReserva $clienteClaseReserva)
    {
        $request->validate([
            'asistencia_estado' => 'required|string|in:asistio,no_asistio',
        ]);

        // El Route Model Binding ya nos da la instancia de ClienteClaseReserva
        // También podrías querer verificar que esta reserva pertenece a la clase
        // que se está visualizando, aunque el ID de la clase no se pasa directamente
        // a esta ruta, sino el ID de la reserva.

        $clienteClaseReserva->estado = $request->input('asistencia_estado');
        if ($request->input('asistencia_estado') == 'asistio') {
            $clienteClaseReserva->fecha_hora_registro_asistencia = now();
        } else {
            $clienteClaseReserva->fecha_hora_registro_asistencia = null; // O mantenerla si ya asistió y se cambia
        }
        $clienteClaseReserva->save();

        // Redirigir de vuelta a la página de detalle de la clase
        // Necesitamos el id_clase de la reserva para construir la URL de redirección.
        return redirect()->route('admin.group_classes.show', $clienteClaseReserva->id_clase)
            ->with('success', '¡Asistencia actualizada exitosamente!');
    }
}