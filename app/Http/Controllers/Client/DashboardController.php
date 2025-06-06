<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClaseGrupal;
use App\Models\ClienteClaseReserva;
use App\Models\SeguimientoProgreso;
use App\Models\AsignacionRutinaCliente;
use App\Models\ClienteMembresia; // <-- MODIFICACIÓN: Importación añadida
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();
        return view('client.dashboard', ['userName' => $user->nombre ?? 'Cliente']);
    }

    public function listGroupClasses()
    {
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();
        $clienteId = Auth::guard('web')->id();

        $availableClasses = ClaseGrupal::with('entrenador')
            ->where(function ($query) use ($today, $now) {
                $query->where('fecha', '>', $today)
                    ->orWhere(function ($query) use ($today, $now) {
                        $query->where('fecha', $today)
                            ->where('hora_inicio', '>', $now->format('H:i:s'));
                    });
            })
            ->where(function ($query) {
                $query->where('estado', 'programada')
                    ->orWhere('estado', 'confirmada');
            })
            ->whereDoesntHave('clienteClaseReservas', function ($query) use ($clienteId) {
                $query->where('id_cliente', $clienteId)
                    ->whereIn('estado', ['confirmada', 'reservado', 'asistio']);
            })
            ->whereRaw('(SELECT COUNT(*) FROM Cliente_Clase_Reserva WHERE Cliente_Clase_Reserva.id_clase = Clase_Grupal.id_clase AND Cliente_Clase_Reserva.estado = "confirmada") < Clase_Grupal.cupo_maximo')
            ->orderBy('fecha', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->paginate(10);

        return view('client.group_classes.index', compact('availableClasses'));
    }

    public function bookClass(Request $request, ClaseGrupal $claseGrupal)
    {
        $cliente = Auth::guard('web')->user();
        $now = Carbon::now();
        $classDateTime = Carbon::parse($claseGrupal->fecha . ' ' . $claseGrupal->hora_inicio);


        if ($claseGrupal->estado !== 'programada' && $claseGrupal->estado !== 'confirmada') {
            return redirect()->route('client.group_classes.list')
                ->with('error', 'Esta clase no está disponible para reservar.');
        }
        if ($classDateTime->isPast()) {
            return redirect()->route('client.group_classes.list')
                ->with('error', 'Esta clase ya ha pasado y no se puede reservar.');
        }

        $existingReservation = ClienteClaseReserva::where('id_cliente', $cliente->id_cliente)
            ->where('id_clase', $claseGrupal->id_clase)
            ->first();

        if ($existingReservation) {
            if ($existingReservation->estado === 'confirmada' || $existingReservation->estado === 'reservado') {
                return redirect()->route('client.group_classes.list')
                    ->with('error', 'Ya tienes una reserva activa para esta clase.');
            } elseif ($existingReservation->estado === 'cancelada_cliente') {
                return redirect()->route('client.group_classes.list')
                    ->with('error', 'Anteriormente tenías una reserva para esta clase que fue cancelada. No puedes volver a reservarla directamente. Contacta con administración si deseas asistir.');
            }
        }

        $reservasConfirmadas = ClienteClaseReserva::where('id_clase', $claseGrupal->id_clase)
            ->where('estado', 'confirmada')
            ->count();

        if ($reservasConfirmadas >= $claseGrupal->cupo_maximo) {
            return redirect()->route('client.group_classes.list')
                ->with('error', 'Lo sentimos, ya no hay cupos disponibles para esta clase.');
        }

        try {
            ClienteClaseReserva::create([
                'id_cliente' => $cliente->id_cliente,
                'id_clase' => $claseGrupal->id_clase,
                'estado' => 'confirmada',
            ]);

            return redirect()->route('client.group_classes.list')
                ->with('success', '¡Reserva realizada exitosamente para la clase: ' . $claseGrupal->nombre . '!');

        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('client.group_classes.list')
                    ->with('error', 'Ya existe una reserva para ti en esta clase.');
            }
            Log::error('Error al reservar clase (QueryException): ' . $e->getMessage() . ' - ClienteID: ' . $cliente->id_cliente . ' ClaseID: ' . $claseGrupal->id_clase);
            return redirect()->route('client.group_classes.list')
                ->with('error', 'Ocurrió un error de base de datos al intentar realizar la reserva.');
        } catch (\Exception $e) {
            Log::error('Error al reservar clase (Exception): ' . $e->getMessage() . ' - ClienteID: ' . $cliente->id_cliente . ' ClaseID: ' . $claseGrupal->id_clase);
            return redirect()->route('client.group_classes.list')
                ->with('error', 'Ocurrió un error inesperado al intentar realizar la reserva. Por favor, inténtalo de nuevo.');
        }
    }

    public function myBookings()
    {
        $clienteId = Auth::guard('web')->id();
        $myBookings = ClienteClaseReserva::with('claseGrupal.entrenador')
            ->where('id_cliente', $clienteId)
            ->orderBy('fecha_reserva', 'desc')
            ->paginate(10);

        return view('client.bookings.index', compact('myBookings'));
    }

    public function cancelBooking(ClienteClaseReserva $clienteClaseReserva)
    {
        if ($clienteClaseReserva->id_cliente !== Auth::guard('web')->user()->id_cliente) {
            return redirect()->route('client.my_bookings')->with('error', 'No tienes permiso para cancelar esta reserva.');
        }
        if (!$clienteClaseReserva->claseGrupal) {
            return redirect()->route('client.my_bookings')->with('error', 'La clase asociada a esta reserva ya no existe.');
        }

        $classDateTime = Carbon::parse($clienteClaseReserva->claseGrupal->fecha . ' ' . $clienteClaseReserva->claseGrupal->hora_inicio);

        if ($classDateTime->isPast()) {
            return redirect()->route('client.my_bookings')->with('error', 'No puedes cancelar una reserva para una clase que ya ha pasado.');
        }
        if ($clienteClaseReserva->estado !== 'confirmada' && $clienteClaseReserva->estado !== 'reservado') {
            return redirect()->route('client.my_bookings')->with('error', 'Solo puedes cancelar reservas que estén confirmadas o reservadas.');
        }
        try {
            $clienteClaseReserva->estado = 'cancelada_cliente';
            $clienteClaseReserva->save();
            return redirect()->route('client.my_bookings')->with('success', '¡Reserva cancelada exitosamente!');
        } catch (\Exception $e) {
            Log::error('Error al cancelar reserva (Exception): ' . $e->getMessage() . ' - ReservaID: ' . $clienteClaseReserva->id_cliente_clase);
            return redirect()->route('client.my_bookings')->with('error', 'Ocurrió un error al intentar cancelar la reserva.');
        }
    }

    public function myProgress()
    {
        $cliente = Auth::guard('web')->user();
        $clienteId = $cliente->id_cliente;

        $progressHistory = SeguimientoProgreso::with(['asignacionRutinaCliente.rutina'])
            ->where('id_cliente', $clienteId)
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return view('client.progress.index', compact('progressHistory', 'cliente'));
    }

    public function myRoutine()
    {
        $cliente = Auth::guard('web')->user();

        $activeAssignment = AsignacionRutinaCliente::where('id_cliente', $cliente->id_cliente)
            ->where('estado', 'activa')
            ->latest('fecha_asignacion')
            ->with([
                'rutina.ejercicios' => function ($query) {
                    $query->orderBy('pivot_orden', 'asc');
                }
            ])
            ->first();

        return view('client.routine.show', compact('activeAssignment', 'cliente'));
    }

    // ===== INICIO DE LA MODIFICACIÓN =====
    /**
     * Muestra el estado de la membresía y el historial de pagos del cliente.
     */
    public function myMembership()
    {
        $cliente = Auth::guard('web')->user();

        // Obtener la membresía activa actual
        $activeMembership = ClienteMembresia::where('id_cliente', $cliente->id_cliente)
            ->where('estado', 'activa')
            ->where('fecha_fin', '>=', now())
            ->with('tipoMembresia')
            ->latest('fecha_fin')
            ->first();

        // Obtener todo el historial de membresías para mostrar en la tabla, con sus pagos
        $membershipHistory = ClienteMembresia::where('id_cliente', $cliente->id_cliente)
            ->with(['tipoMembresia', 'pagos']) // Carga ansiosa para evitar problemas N+1
            ->latest('fecha_inicio') // Ordena por la más reciente
            ->paginate(5); // Pagina el historial

        return view('client.membership.index', compact('activeMembership', 'membershipHistory', 'cliente'));
    }
    // ===== FIN DE LA MODIFICACIÓN =====
}