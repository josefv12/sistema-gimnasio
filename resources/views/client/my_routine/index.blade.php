@extends('layouts.trainer')

@section('title', 'Gestionar Rutina de ' . $cliente->nombre)

@section('page-title')
    <div class="d-flex justify-content-between align-items-center">
        <span>Gestionar Rutina de: <strong>{{ $cliente->nombre }}</strong></span>
        <a href="{{ route('trainer.my_clients.list') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Volver a Mis Clientes
        </a>
    </div>
@endsection

@section('content')
    {{-- Bloque de Alertas --}}
    @if (session('success'))
        <div class="alert alert-success mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <p class="fw-bold">Por favor, corrige los siguientes errores:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-5">
            {{-- Muestra la rutina activa si existe --}}
            @if ($asignacionActiva)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Rutina Asignada Actualmente</h5>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $asignacionActiva->rutina->nombre }}</h4>
                        <p class="card-text">
                            <small class="text-muted">
                                Asignada el: {{ $asignacionActiva->fecha_asignacion->format('d/m/Y') }}
                            </small>
                        </p>
                    </div>
                </div>
            @endif

            {{-- Tarjeta para crear una nueva rutina --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ $asignacionActiva ? 'Asignar una Nueva Rutina (reemplazará la actual)' : 'Crear Nueva Rutina para el Cliente' }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('trainer.clients.routine.store', $cliente->id_cliente) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre_rutina" class="form-label">Nombre de la Rutina</label>
                            <input type="text" class="form-control" id="nombre_rutina" name="nombre_rutina" placeholder="Ej: Semana 1 - Acondicionamiento" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Crear y Asignar</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Columna para los ejercicios de la rutina --}}
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Ejercicios de la Rutina</h5>
                    @if ($asignacionActiva)
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addExerciseModal">
                            <i class="bi bi-plus-lg"></i> Añadir Ejercicio
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    @if ($asignacionActiva)
                        @forelse ($asignacionActiva->rutina->rutinaEjercicios as $rutinaEjercicio)
                            <div class="p-2 border-bottom">
                                <strong>{{ $rutinaEjercicio->ejercicio->nombre }}</strong>
                                <p class="mb-1 text-muted">
                                    {{ $rutinaEjercicio->series }} series x {{ $rutinaEjercicio->repeticiones }} repeticiones | Descanso: {{ $rutinaEjercicio->descanso_segundos }}s
                                </p>
                            </div>
                        @empty
                            <p class="text-muted">Esta rutina aún no tiene ejercicios. ¡Añade el primero!</p>
                        @endforelse
                    @else
                        <p class="text-muted">Primero crea y asigna una rutina para poder añadirle ejercicios.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>


    @if ($asignacionActiva)
    <div class="modal fade" id="addExerciseModal" tabindex="-1" aria-labelledby="addExerciseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExerciseModalLabel">Añadir Ejercicio a la Rutina: {{ $asignacionActiva->rutina->nombre }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('trainer.clients.routine.add_exercise', $asignacionActiva->rutina->id_rutina) }}" method="POST">
                    
                    {{-- ===== INICIO DE LA CORRECCIÓN ===== --}}
                    @csrf  {{-- <--- ESTA ES LA LÍNEA AÑADIDA QUE SOLUCIONA EL ERROR --}}
                    {{-- ===== FIN DE LA CORRECCIÓN ===== --}}

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_ejercicio" class="form-label">Ejercicio</label>
                            <select class="form-select" name="id_ejercicio" id="id_ejercicio" required>
                                <option value="">Seleccionar ejercicio...</option>
                                @foreach ($ejerciciosDisponibles as $ejercicio)
                                    <option value="{{ $ejercicio->id_ejercicio }}">{{ $ejercicio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="series" class="form-label">Series</label>
                                <input type="text" class="form-control" name="series" id="series" placeholder="Ej: 4" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="repeticiones" class="form-label">Repeticiones</label>
                                <input type="text" class="form-control" name="repeticiones" id="repeticiones" placeholder="Ej: 8-10" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="duracion_segundos" class="form-label">Duración (segundos)</label>
                                <input type="number" class="form-control" name="duracion_segundos" id="duracion_segundos" placeholder="Ej: 60">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="descanso_segundos" class="form-label">Descanso (segundos)</label>
                                <input type="number" class="form-control" name="descanso_segundos" id="descanso_segundos" placeholder="Ej: 90">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="notas" class="form-label">Instrucciones Específicas (Opcional)</label>
                            <textarea class="form-control" name="notas" id="notas" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Ejercicio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection