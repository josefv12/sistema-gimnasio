@extends('layouts.trainer')

@section('title', 'Mis Clientes')

@section('page-title', 'Listado de Clientes')

@section('content')
    @if (session('success'))
        <div class="alert alert-success mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('warning') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mb-3" role="alert">
            <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
        </div>
    @endif

    @if(isset($clients) && !$clients->isEmpty())
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Clientes Asignados</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td>{{ $client->id_cliente }}</td>
                                <td>{{ $client->nombre }}</td>
                                <td>{{ $client->correo }}</td>
                                <td>{{ $client->telefono ?? 'N/A' }}</td>

                                {{-- ===== INICIO DE LA MODIFICACIÓN ===== --}}
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Acciones de Cliente">

                                        {{-- Botón de Check-in --}}
                                        <form action="{{ route('trainer.clients.attendance.store', $client->id_cliente) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success"
                                                title="Registrar Asistencia (Check-in)">
                                                <i class="bi bi-person-check-fill"></i>
                                            </button>
                                        </form>

                                        {{-- Botón para Gestionar Rutina --}}
                                        <a href="{{ route('trainer.clients.routine.index', $client->id_cliente) }}"
                                            class="btn btn-sm btn-secondary" title="Gestionar Rutina">
                                            <i class="bi bi-list-task"></i>
                                        </a>

                                        {{-- Botón de Progreso --}}
                                        <a href="{{ route('trainer.clients.progress_tracking', $client->id_cliente) }}"
                                            class="btn btn-sm btn-info" title="Ver/Registrar Progreso">
                                            <i class="bi bi-graph-up"></i>
                                        </a>

                                    </div>
                                </td>
                                {{-- ===== FIN DE LA MODIFICACIÓN ===== --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($clients->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $clients->links() }}
            </div>
        @endif
    @else
        <div class="alert alert-info">
            No hay clientes asignados a ti por el momento.
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('trainer.dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left-circle"></i> Volver
            al Dashboard</a>
    </div>
@endsection