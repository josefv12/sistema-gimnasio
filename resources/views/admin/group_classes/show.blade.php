@extends('layouts.admin')

@section('title', 'Detalle de Clase: ' . $claseGrupal->nombre)

@section('page-title', 'Detalle de Clase: ' . $claseGrupal->nombre)

@section('content')
    {{-- Mostrar mensajes de sesión (para la página general o para acciones de asistencia) --}}
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
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-info-circle-fill me-2"></i>Información de la Clase</h5>
                    <a href="{{ route('admin.group_classes.edit', $claseGrupal->id_clase) }}"
                        class="btn btn-light btn-sm"><i class="bi bi-pencil-fill"></i> Editar Clase</a>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Nombre:</dt>
                        <dd class="col-sm-8">{{ $claseGrupal->nombre }}</dd>

                        <dt class="col-sm-4">Descripción:</dt>
                        <dd class="col-sm-8">{{ $claseGrupal->descripcion ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Fecha:</dt>
                        <dd class="col-sm-8">{{ $claseGrupal->fecha->format('d/m/Y') }}</dd>

                        <dt class="col-sm-4">Hora de Inicio:</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($claseGrupal->hora_inicio)->format('h:i A') }}</dd>

                        <dt class="col-sm-4">Hora de Fin:</dt>
                        <dd class="col-sm-8">
                            {{ $claseGrupal->hora_fin ? \Carbon\Carbon::parse($claseGrupal->hora_fin)->format('h:i A') : 'N/A' }}
                        </dd>

                        <dt class="col-sm-4">Entrenador:</dt>
                        <dd class="col-sm-8">{{ $claseGrupal->entrenador->nombre ?? 'No asignado' }}</dd>

                        <dt class="col-sm-4">Cupo Máximo:</dt>
                        <dd class="col-sm-8">{{ $claseGrupal->cupo_maximo }}</dd>

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

        {{-- Columna para Clientes Inscritos --}}
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Inscritos (Confirmados: {{ $cuposOcupados }}) /
                        Disponibles: {{ $cuposDisponibles }}</h5>
                </div>
                <div class="card-body">
                    @if($claseGrupal->clienteClaseReservas && !$claseGrupal->clienteClaseReservas->isEmpty())
                        <ul class="list-group list-group-flush">
                            @foreach ($claseGrupal->clienteClaseReservas->sortBy('cliente.nombre') as $reserva)
                                <li class="list-group-item">
                                    <div>
                                        <strong><i
                                                class="bi bi-person-check-fill me-1"></i>{{ $reserva->cliente->nombre ?? 'Cliente no disponible' }}</strong>
                                        <small class="text-muted d-block">Correo: {{ $reserva->cliente->correo ?? 'N/A' }}</small>
                                        <small class="text-muted d-block">Reservado el:
                                            {{ $reserva->fecha_reserva->format('d/m/Y h:i A') }}</small>
                                        <span class="mt-1 d-inline-block">Estado Reserva:
                                            @if($reserva->estado == 'confirmada')
                                                <span class="badge bg-success">Confirmada</span>
                                            @elseif($reserva->estado == 'cancelada_cliente')
                                                <span class="badge bg-warning text-dark">Cancelada (Cliente)</span>
                                            @elseif($reserva->estado == 'asistio')
                                                <span class="badge bg-primary">Asistió</span>
                                            @elseif($reserva->estado == 'no_asistio')
                                                <span class="badge bg-secondary">No Asistió</span>
                                            @else
                                                <span class="badge bg-light text-dark">{{ ucfirst($reserva->estado) }}</span>
                                            @endif
                                        </span>
                                    </div>
                                    {{-- Solo mostrar botones de asistencia si la reserva está confirmada y la clase no ha sido
                                    marcada como 'realizada' o 'cancelada' aun --}}
                                    @if($reserva->estado == 'confirmada' && !in_array($claseGrupal->estado, ['realizada', 'cancelada']))
                                        <div class="mt-2">
                                            {{-- FORMULARIO MARCAR ASISTIÓ --}}
                                            <form
                                                action="{{ route('admin.group_classes.mark_attendance', $reserva->id_cliente_clase) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="asistencia_estado" value="asistio">
                                                <button type="submit" class="btn btn-xs btn-success">Marcar Asistió</button>
                                            </form>

                                            {{-- FORMULARIO MARCAR NO ASISTIÓ --}}
                                            <form
                                                action="{{ route('admin.group_classes.mark_attendance', $reserva->id_cliente_clase) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="asistencia_estado" value="no_asistio">
                                                <button type="submit" class="btn btn-xs btn-outline-danger ms-1">Marcar No
                                                    Asistió</button>
                                            </form>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted fst-italic">No hay clientes con reservas para esta clase.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.group_classes.index') }}" class="btn btn-secondary"><i
                class="bi bi-arrow-left-circle-fill me-2"></i>Volver al Listado de Clases</a>
    </div>
@endsection

@push('styles')
    <style>
        /* Ya debería estar en layouts.admin.blade.php */
        .card-header h4,
        .card-header h5 {
            margin-bottom: 0;
        }

        dl.row dt {
            font-weight: bold;
        }

        dl.row dd {
            margin-bottom: .5rem;
        }

        .list-group-item strong {
            font-size: 1rem;
        }

        .list-group-item small.d-block {
            margin-top: .25rem;
        }
    </style>
@endpush