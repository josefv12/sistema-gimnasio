@extends('layouts.app')

@section('title', 'Mi Historial de Progreso')

@section('content')
    <div class="container">
        <h1 class="page-title">Mi Historial de Progreso</h1>

        {{-- Tarjeta de Información del Cliente --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Cliente: {{ $cliente->nombre ?? 'Usuario' }}</h5>
            </div>
            <div class="card-body">
                <p>Aquí puedes ver todos los registros de tu progreso a lo largo del tiempo.</p>
            </div>
        </div>

        {{-- Historial de Progreso --}}
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Historial Detallado</h5>
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
                                <th>Rutina Asociada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($progressHistory as $progress)
                                <tr>
                                    <td>{{ $progress->fecha ? $progress->fecha->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td>{{ $progress->peso ?? 'N/A' }}</td>
                                    <td>{{ $progress->medidas ?? 'N/A' }}</td>
                                    <td>{{ $progress->rendimiento_notas ?? 'N/A' }}</td>
                                    <td>
                                        {{-- Verificamos si las relaciones anidadas existen antes de intentar acceder a ellas --}}
                                        @if($progress->asignacionRutinaCliente && $progress->asignacionRutinaCliente->rutina)
                                            {{ $progress->asignacionRutinaCliente->rutina->nombre }}
                                        @else
                                            N/A
                                        @endif
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
                    <p class="text-muted fst-italic">Aún no tienes registros de progreso.</p>
                </div>
            @endif
        </div>

        <div class="mt-4">
            <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver al Dashboard
            </a>
        </div>
    </div>
@endsection