@extends('layouts.trainer')

@section('title', 'Progreso de ' . $cliente->nombre)

@section('page-title', 'Seguimiento de Progreso: ' . $cliente->nombre)

@section('content')
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

    {{-- Tarjeta de Información del Cliente --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Cliente: {{ $cliente->nombre }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Correo:</strong> {{ $cliente->correo }}</p>
            <p><strong>Edad:</strong> {{ $cliente->edad ?? 'N/A' }}</p>
            <p><strong>Género:</strong> {{ $cliente->genero ?? 'N/A' }}</p>
            <p><strong>Teléfono:</strong> {{ $cliente->telefono ?? 'N/A' }}</p>
        </div>
    </div>

    {{-- Botón para Registrar Nuevo Progreso (condicional si es cliente "asignado") --}}
    {{-- Puedes ajustar la condición $isClientOfTrainer según tu lógica de negocio --}}
    @if($isClientOfTrainer)
        <div class="mb-3">
            <a href="{{route('trainer.clients.progress.create', $cliente->id_cliente) }}" class="btn btn-primary"><i class="bi bi-plus-circle-fill me-2"></i>Registrar Nuevo Progreso</a>
        </div>
    @else
        <div class="alert alert-warning">
            Nota: Actualmente no tienes rutinas asignadas a este cliente. Podrás ver su progreso, pero para registrar nuevo progreso, considera asignarle una rutina primero o consulta con administración.
        </div>
    @endif


    {{-- Historial de Progreso --}}
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Historial de Progreso</h5>
        </div>
        @if(isset($progressHistory) && !$progressHistory->isEmpty())
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Fecha Medición</th>
                            <th>Peso (kg)</th>
                            <th>Medidas</th>
                            <th>Notas de Rendimiento</th>
                            <th>Rutina Asignada (ID)</th> {{-- Si está vinculado a una asignación --}}
                            {{-- <th>Acciones</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($progressHistory as $progress)
                            <tr>
                                {{-- Usar el nombre de columna 'fecha' de tu migración Seguimiento_Progreso --}}
                                <td>{{ $progress->fecha ? \Carbon\Carbon::parse($progress->fecha)->format('d/m/Y H:i') : 'N/A' }}</td>
                                {{-- Usar el nombre de columna 'peso' de tu migración Seguimiento_Progreso --}}
                                <td>{{ $progress->peso ?? 'N/A' }}</td>
                                <td>{{ Str::limit($progress->medidas, 70) ?? 'N/A' }}</td>
                                <td>{{ Str::limit($progress->rendimiento_notas, 70) ?? 'N/A' }}</td>
                                <td>{{ $progress->id_asignacion ?? 'N/A' }}</td>
                                <td>
                                    {{-- Botones de editar/eliminar progreso (funcionalidad futura) --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($progressHistory->hasPages())
            <div class="card-footer d-flex justify-content-center">
                {{ $progressHistory->links() }}
            </div>
            @endif
        @else
            <div class="card-body">
                <p class="text-muted fst-italic">No hay registros de progreso para este cliente todavía.</p>
            </div>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('trainer.my_clients.list') }}" class="btn btn-secondary"><i class="bi bi-arrow-left-circle"></i> Volver al Listado de Clientes</a>
    </div>
@endsection