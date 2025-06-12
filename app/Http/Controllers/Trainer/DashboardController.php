<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClaseGrupal;
use App\Models\ClienteClaseReserva;
use App\Models\Cliente;
use App\Models\AsignacionRutinaCliente;
use App\Models\SeguimientoProgreso;
use Carbon\Carbon;
use App\Models\Asistencia;

class DashboardController extends Controller
{
    // ... (todos tus otros métodos como index, listMyClasses, etc. se mantienen igual) ...
    public function index()
    {
        $user = Auth::guard('trainer')->user();
        return view('trainer.dashboard', ['userName' => $user->nombre ?? 'Entrenador']);
    }

    public function listMyClasses()
    {
        $trainerId = Auth::guard('trainer')->id();
        $today = Carbon::today()->toDateString();

        $myClasses = ClaseGrupal::where('id_entrenador', $trainerId)
            ->where(function ($query) use ($today) {
                $query->where('fecha', '>=', $today);
            })
            ->whereIn('estado', ['programada', 'confirmada'])
            ->orderBy('fecha', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->paginate(10);

        return view('trainer.my_classes.index', compact('myClasses'));
    }

    public function showClassForAttendance(ClaseGrupal $claseGrupal)
    {
        $trainerId = Auth::guard('trainer')->id();

        if ($claseGrupal->id_entrenador !== $trainerId) {
            return redirect()->route('trainer.my_classes.list')->with('error', 'No tienes permiso para ver los detalles de esa clase.');
        }

        $claseGrupal->load(['clienteClaseReservas.cliente']);
        $cuposOcupados = $claseGrupal->clienteClaseReservas->where('estado', 'confirmada')->count();
        $cuposDisponibles = $claseGrupal->cupo_maximo - $cuposOcupados;

        return view('trainer.my_classes.attendance', compact('claseGrupal', 'cuposOcupados', 'cuposDisponibles'));
    }

    public function markTrainerAttendance(Request $request, ClienteClaseReserva $clienteClaseReserva)
    {
        $trainerId = Auth::guard('trainer')->id();

        if (!$clienteClaseReserva->claseGrupal || $clienteClaseReserva->claseGrupal->id_entrenador !== $trainerId) {
            return redirect()->route('trainer.my_classes.list')->with('error', 'No tienes permiso para marcar asistencia en esta clase.');
        }

        if ($clienteClaseReserva->estado === 'cancelada_cliente') {
            return redirect()->route('trainer.my_classes.attendance', $clienteClaseReserva->id_clase)
                ->with('error', 'No se puede marcar asistencia para una reserva cancelada por el cliente.');
        }

        $request->validate([
            'asistencia_estado' => 'required|string|in:asistio,no_asistio',
        ]);

        $clienteClaseReserva->estado = $request->input('asistencia_estado');
        if ($request->input('asistencia_estado') == 'asistio') {
            $clienteClaseReserva->fecha_hora_registro_asistencia = now();
        } else {
            $clienteClaseReserva->fecha_hora_registro_asistencia = null;
        }
        $clienteClaseReserva->save();

        return redirect()->route('trainer.my_classes.attendance', $clienteClaseReserva->id_clase)
            ->with('success', '¡Asistencia actualizada exitosamente para ' . ($clienteClaseReserva->cliente->nombre ?? 'el cliente') . '!');
    }

    public function listMyClients()
    {
        $trainerId = Auth::guard('trainer')->id();
        $clientIds = AsignacionRutinaCliente::where('id_entrenador', $trainerId)
            ->distinct()
            ->pluck('id_cliente');
        $clients = Cliente::whereIn('id_cliente', $clientIds)
            ->orderBy('nombre', 'asc')
            ->paginate(10);
        return view('trainer.my_clients.index', compact('clients'));
    }

    public function showClientProgress(Cliente $cliente)
    {
        $trainerId = Auth::guard('trainer')->id();
        $isClientOfTrainer = AsignacionRutinaCliente::where('id_cliente', $cliente->id_cliente)
            ->where('id_entrenador', $trainerId)
            ->exists();
        $progressHistory = SeguimientoProgreso::where('id_cliente', $cliente->id_cliente)
            ->orderBy('fecha', 'desc')
            ->paginate(10);
        return view('trainer.clients.progress.index', compact('cliente', 'progressHistory', 'isClientOfTrainer'));
    }

    public function createClientProgress(Cliente $cliente)
    {
        $trainerId = Auth::guard('trainer')->id();
        $activeRoutineAssignments = AsignacionRutinaCliente::where('id_cliente', $cliente->id_cliente)
            ->where('estado', 'activa')
            ->with('rutina')
            ->get();
        return view('trainer.clients.progress.create', compact('cliente', 'activeRoutineAssignments'));
    }

    public function storeClientProgress(Request $request, Cliente $cliente)
    {
        $trainerId = Auth::guard('trainer')->id();

        $validatedData = $request->validate([
            'fecha' => 'required|date',
            'peso' => 'nullable|numeric|min:0|max:500',
            'medidas' => 'nullable|string',
            'rendimiento_notas' => 'nullable|string',
            'id_asignacion' => 'nullable|exists:Asignacion_Rutina_Cliente,id_asignacion',
        ]);

        $dataToStore = array_merge($validatedData, [
            'id_cliente' => $cliente->id_cliente,
        ]);

        if (isset($dataToStore['id_asignacion']) && $dataToStore['id_asignacion'] === '') {
            $dataToStore['id_asignacion'] = null;
        }

        SeguimientoProgreso::create($dataToStore);

        return redirect()->route('trainer.clients.progress_tracking', $cliente->id_cliente)
            ->with('success', '¡Nuevo progreso registrado exitosamente para ' . $cliente->nombre . '!');
    }

    // ===== INICIO DE LA MODIFICACIÓN CORREGIDA =====
    /**
     * Registra una nueva asistencia (check-in) diaria para un cliente.
     * Verifica que no se haya registrado una asistencia previa en el mismo día.
     */
    public function registerAttendance(Cliente $cliente)
    {
        // 1. Verificar si ya existe un registro de asistencia para este cliente HOY.
        $today = Carbon::today();
        $asistenciaExistente = Asistencia::where('id_cliente', $cliente->id_cliente)
            // Usamos el nombre correcto de la columna: 'hora_entrada'
            ->whereDate('hora_entrada', $today)
            ->exists();

        // 2. Si ya existe, redirigir con un mensaje de advertencia.
        if ($asistenciaExistente) {
            return back()->with('warning', 'La asistencia para ' . $cliente->nombre . ' ya fue registrada el día de hoy.');
        }

        // 3. Si no existe, crear el nuevo registro con los campos correctos.
        $cliente->asistencias()->create([
            // Usamos el nombre correcto: 'hora_entrada'
            'hora_entrada' => now(),
            // Añadimos el tipo de registro para que coincida con el modelo
            'tipo_registro' => 'general',
        ]);

        // 4. Redirigir con un mensaje de éxito.
        return back()->with('success', 'Asistencia registrada para ' . $cliente->nombre);
    }
    // ===== FIN DE LA MODIFICACIÓN CORREGIDA =====
}