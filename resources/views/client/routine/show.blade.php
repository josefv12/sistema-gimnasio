@extends('layouts.app')

@section('title', 'Mi Rutina Asignada')

@section('content')
<div class="container">
    <h1 class="page-title">Mi Rutina de Entrenamiento</h1>

    @if($activeAssignment)
        {{-- Tarjeta de Información de la Rutina --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="bi bi-list-task me-2"></i>
                    {{ $activeAssignment->rutina->nombre ?? 'Rutina Asignada' }}
                </h4>
            </div>
            <div class="card-body">
                @if($activeAssignment->notas_entrenador)
                    <p class="card-text">
                        <strong>Notas del Entrenador:</strong>
                        <em class="d-block border-start border-4 border-info ps-3 py-2 bg-light mt-2">
                            {{ $activeAssignment->notas_entrenador }}
                        </em>
                    </p>
                @endif
                <p class="text-muted">
                    Asignada el: {{ $activeAssignment->fecha_asignacion->format('d/m/Y') }}
                </p>
            </div>
        </div>

        {{-- Listado de Ejercicios --}}
        <h2 class="h4 mb-3">Ejercicios del Día</h2>
        @if($activeAssignment->rutina && $activeAssignment->rutina->ejercicios->isNotEmpty())
            @foreach($activeAssignment->rutina->ejercicios as $exercise)
                <div class="card shadow-sm mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <span class="badge bg-primary me-2">{{ $exercise->pivot->orden }}</span>
                            {{ $exercise->nombre }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                @if($exercise->pivot->series || $exercise->pivot->repeticiones || $exercise->pivot->duracion || $exercise->pivot->descanso)
                                    <ul class="list-group list-group-flush mb-3">
                                        @if($exercise->pivot->series)
                                            <li class="list-group-item"><strong>Series:</strong> {{ $exercise->pivot->series }}</li>
                                        @endif
                                        @if($exercise->pivot->repeticiones)
                                            <li class="list-group-item"><strong>Repeticiones:</strong> {{ $exercise->pivot->repeticiones }}</li>
                                        @endif
                                        @if($exercise->pivot->duracion)
                                            <li class="list-group-item"><strong>Duración:</strong> {{ $exercise->pivot->duracion }}</li>
                                        @endif
                                        @if($exercise->pivot->descanso)
                                            <li class="list-group-item"><strong>Descanso:</strong> {{ $exercise->pivot->descanso }}</li>
                                        @endif
                                    </ul>
                                @endif
                                @if($exercise->pivot->notas)
                                    <p><strong>Instrucciones Específicas:</strong> {{ $exercise->pivot->notas }}</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <p><strong>Descripción General del Ejercicio:</strong><br>
                                    <small>{{ $exercise->descripcion ?? 'Sin descripción.' }}</small>
                                </p>
                                <p><strong>Instrucciones de Ejecución:</strong><br>
                                    <small>{{ $exercise->instrucciones ?? 'Sin instrucciones generales.' }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-warning">
                Tu rutina asignada no tiene ejercicios todavía. Por favor, contacta a tu entrenador.
            </div>
        @endif

    @else
        <div class="alert alert-info">
            <h4 class="alert-heading">¡Aún no tienes una rutina activa!</h4>
            <p>Parece que no tienes una rutina de entrenamiento activa asignada en este momento. Por favor, habla con tu entrenador para que te asigne un plan de entrenamiento personalizado.</p>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle"></i> Volver al Dashboard
        </a>
    </div>
</div>
@endsection