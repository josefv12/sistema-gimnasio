@extends('layouts.trainer') {{-- O el layout que uses para el portal de entrenador --}}

@section('title', 'Asistencia Clase: ' . $claseGrupal->nombre)

@section('page-title', 'Gestionar Asistencia: ' . $claseGrupal->nombre)

@section('content')
    {{-- Mensajes de sesión --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- Columna para Información de la Clase --}}
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle-fill me-2"></i>Información de la Clase</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Nombre:</dt>
                        <dd class="col-sm-8">{{ $claseGrupal->nombre }}</dd>
                        <dt class="col-sm-4">Fecha:</dt>
                        <dd class="col-sm-8">{{ $claseGrupal->fecha->format('d/m/Y') }}</dd>
                        <dt class="col-sm-4">Hora de Inicio:</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($claseGrupal->hora_inicio)->format('h:i A') }}</dd>
                        <dt class="col-sm-4">Estado de la Clase:</dt>
                        <dd class="col-sm-8">
                            @if($claseGrupal->estado == 'programada')
                                <span class="badge bg-info text-dark">Programada</span>
                            @elseif($claseGrupal->estado == 'confirmada')
                                <span class="badge bg-success">Confirmada</span>
                            @elseif($claseGrupal->estado == 'cancelada')
                                <span class="badge bg-danger">Cancelada</span>
                            @elseif($claseGrupal->estado == 'realizada')
                                <span class="badge bg-secondary">Realizada</span>
                            @else
                                <span class="badge bg-light text-dark">{{ ucfirst($claseGrupal->estado) }}</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Columna para Clientes Inscritos y Marcar Asistencia --}}
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Inscritos (Confirmados: {{ $cuposOcupados }}) / Disponibles: {{ $cuposDisponibles }}</h5>
                </div>
                <div class="card-body">
                    @if($claseGrupal->clienteClaseReservas && !$claseGrupal->clienteClaseReservas->where('estado', 'confirmada')->isEmpty())
                        <p><strong>Reservas Confirmadas:</strong></p>
                        <ul class="list-group list-group-flush">
                            @foreach ($claseGrupal->clienteClaseReservas->where('estado', 'confirmada')->sortBy('cliente.nombre') as $reserva)
                                <li class="list-group-item">
                                    <div>
                                        <strong><i class="bi bi-person-check-fill me-1"></i>{{ $reserva->cliente->nombre ?? 'Cliente no disponible' }}</strong>
                                    </div>
                                    {{-- Solo mostrar botones si la clase no está realizada o cancelada --}}
                                    @if(!in_array($claseGrupal->estado, ['realizada', 'cancelada']))
                                    <div class="mt-2">
                                        <form action="{{ route('trainer.my_classes.mark_attendance_action', $reserva->id_cliente_clase) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="asistencia_estado" value="asistio">
                                            <button type="submit" class="btn btn-xs btn-success">Marcar Asistió</button>
                                        </form>
                                        <form action="{{ route('trainer.my_classes.mark_attendance_action', $reserva->id_cliente_clase) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="asistencia_estado" value="no_asistio">
                                            <button type="submit" class="btn btn-xs btn-outline-danger ms-1">Marcar No Asistió</button>
                                        </form>
                                    </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted fst-italic">No hay clientes con reservas confirmadas para esta clase.</p>
                    @endif

                    {{-- Mostrar otras reservas (ej. ya asistió, no asistió, canceladas) --}}
                    @php
                        $otrasReservas = $claseGrupal->clienteClaseReservas->whereNotIn('estado', ['confirmada']);
                    @endphp
                    @if(!$otrasReservas->isEmpty())
                        <hr>
                        <p class="mt-3"><strong>Otros Estados de Reserva:</strong></p>
                        <ul class="list-group list-group-flush">
                             @foreach ($otrasReservas->sortBy('cliente.nombre') as $reserva)
                                <li class="list-group-item">
                                    <strong><i class="bi bi-person me-1"></i>{{ $reserva->cliente->nombre ?? 'Cliente no disponible' }}</strong> - 
                                    @if($reserva->estado == 'cancelada_cliente')
                                        <span class="badge bg-warning text-dark">Cancelada (Cliente)</span>
                                    @elseif($reserva->estado == 'asistio')
                                        <span class="badge bg-primary">Asistió</span>
                                    @elseif($reserva->estado == 'no_asistio')
                                        <span class="badge bg-secondary">No Asistió</span>
                                    @else
                                        <span class="badge bg-light text-dark">{{ ucfirst($reserva->estado) }}</span>
                                    @endif
                                     @if($reserva->fecha_hora_registro_asistencia)
                                        <small class="text-muted d-block">Registrado: {{ \Carbon\Carbon::parse($reserva->fecha_hora_registro_asistencia)->format('d/m/Y h:i A') }}</small>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('trainer.my_classes.list') }}" class="btn btn-secondary"><i class="bi bi-arrow-left-circle-fill me-2"></i>Volver al Listado de Mis Clases</a>
    </div>
@endsection