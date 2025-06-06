@extends('layouts.app')

@section('title', 'Mis Reservas de Clases Grupales')

@section('content')
    <h1 class="page-title">Mis Reservas</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session(key: 'error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($myBookings) && !$myBookings->isEmpty())
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach ($myBookings as $booking)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div
                            class="card-header @if($booking->estado == 'confirmada') bg-success text-white @elseif($booking->estado == 'cancelada_cliente') bg-warning text-dark @elseif($booking->estado == 'asistio') bg-info text-white @elseif($booking->estado == 'no_asistio') bg-secondary text-white @else bg-light @endif">
                            Reserva para: <strong>{{ $booking->claseGrupal->nombre ?? 'Clase no disponible' }}</strong>
                        </div>
                        <div class="card-body">
                            @if($booking->claseGrupal)
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <i class="bi bi-calendar-event"></i> {{ $booking->claseGrupal->fecha->format('d/m/Y') }}
                                    a las <i class="bi bi-clock"></i>
                                    {{ \Carbon\Carbon::parse($booking->claseGrupal->hora_inicio)->format('h:i A') }}
                                </h6>
                                <p class="card-text">
                                    <small>
                                        Entrenador: {{ $booking->claseGrupal->entrenador->nombre ?? 'No asignado' }} <br>
                                        Estado de tu reserva:
                                        @if($booking->estado == 'confirmada')
                                            <span class="badge bg-success">Confirmada</span>
                                        @elseif($booking->estado == 'cancelada_cliente')
                                            <span class="badge bg-warning text-dark">Cancelada por ti</span>
                                        @elseif($booking->estado == 'asistio')
                                            <span class="badge bg-info">Asistió</span>
                                        @elseif($booking->estado == 'no_asistio')
                                            <span class="badge bg-secondary">No Asistió</span>
                                        @else
                                            <span class="badge bg-light text-dark">{{ ucfirst($booking->estado) }}</span>
                                        @endif
                                    </small>
                                </p>
                                <p class="card-text"><small class="text-muted">Reservado el:
                                        {{ $booking->fecha_reserva->format('d/m/Y H:i') }}</small></p>
                            @else
                                <p class="text-danger">Información de la clase no disponible.</p>
                            @endif
                        </div>
                        {{-- Lógica para el botón de cancelar --}}
                        @if($booking->claseGrupal && \Carbon\Carbon::parse($booking->claseGrupal->fecha->toDateString() . ' ' . $booking->claseGrupal->hora_inicio)->isFuture() && ($booking->estado == 'confirmada' || $booking->estado == 'reservado'))
                            <div class="card-footer bg-transparent border-top-0">
                                <form action="{{ route('client.bookings.cancel', $booking->id_cliente_clase) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de que deseas cancelar esta reserva?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100"><i class="bi bi-x-circle"></i>
                                        Cancelar Reserva</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $myBookings->links() }}
        </div>
    @else
        <div class="alert alert-info mt-3">
            Aún no tienes ninguna clase grupal reservada. ¡<a href="{{ route('client.group_classes.list') }}"
                class="alert-link">Anímate a reservar una</a>!
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left-circle"></i>
            Volver al Dashboard</a>
    </div>
@endsection