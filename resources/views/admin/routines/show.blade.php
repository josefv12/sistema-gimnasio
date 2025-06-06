@extends('layouts.admin')

@section('title', 'Detalle de Rutina: ' . $rutina->nombre)

@section('page-title', 'Detalle de Rutina: ' . $rutina->nombre)

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Información de la Rutina</h4>
        </div>
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $rutina->nombre }}</p>
            <p><strong>Creador:</strong> {{ $rutina->entrenadorCreador->nombre ?? 'Sistema / N/A' }}</p>
            {{-- Mostrar descripción, objetivo, nivel si los tienes y los pasas a la vista --}}
            {{-- <p><strong>Descripción:</strong> {{ $rutina->descripcion ?? 'N/A' }}</p> --}}
            {{-- <p><strong>Objetivo:</strong> {{ $rutina->objetivo ?? 'N/A' }}</p> --}}
            {{-- <p><strong>Nivel:</strong> {{ $rutina->nivel ?? 'N/A' }}</p> --}}
        </div>
    </div>

    <hr>

    <div class="card mt-4">
        <div class="card-header">
            <h4>Ejercicios Asignados a esta Rutina</h4>
        </div>
        <div class="card-body">
            @if (session('exercise_success'))
                <div class="alert alert-success mb-3">
                    {{ session('exercise_success') }}
                </div>
            @endif
            @if (session('exercise_error'))
                <div class="alert alert-danger mb-3">
                    {{ session('exercise_error') }}
                </div>
            @endif

            @if($rutina->ejercicios && !$rutina->ejercicios->isEmpty())
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Orden</th>
                            <th>Ejercicio</th>
                            <th>Series</th>
                            <th>Repeticiones</th>
                            <th>Duración</th>
                            <th>Descanso</th>
                            <th>Notas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Ordenar por el campo 'orden' del pivote --}}
                        @foreach ($rutina->ejercicios->sortBy('pivot.orden') as $ejercicio)
                            <tr>
                                <td>{{ $ejercicio->pivot->orden }}</td>
                                <td>{{ $ejercicio->nombre }}</td>
                                <td>{{ $ejercicio->pivot->series ?? 'N/A' }}</td>
                                <td>{{ $ejercicio->pivot->repeticiones ?? 'N/A' }}</td>
                                <td>{{ $ejercicio->pivot->duracion ?? 'N/A' }}</td>
                                <td>{{ $ejercicio->pivot->descanso ?? 'N/A' }}</td>
                                <td>{{ Str::limit($ejercicio->pivot->notas, 50) ?? 'N/A' }}</td>
                                <td>
                                    {{-- Enlace para Editar Detalles del Ejercicio en la Rutina (NUEVO) --}}
                                    <a href="{{ route('admin.routines.edit_exercise_details', ['rutina' => $rutina->id_rutina, 'rutinaEjercicio' => $ejercicio->pivot->id_rutina_ejercicio]) }}"
                                        class="btn btn-xs btn-secondary">Editar Detalles</a>
                                    <form
                                        action="{{ route('admin.routines.remove_exercise', ['rutina' => $rutina->id_rutina, 'ejercicio' => $ejercicio->id_ejercicio]) }}"
                                        method="POST" style="display:inline;"
                                        onsubmit="return confirm('¿Estás seguro de que quieres quitar este ejercicio de la rutina?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger">Quitar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Aún no hay ejercicios asignados a esta rutina.</p>
            @endif
        </div>
    </div>

    <hr>

    {{-- ... (Formulario para Añadir Nuevo Ejercicio a la Rutina - sin cambios) ... --}}
    <div class="card mt-4">
        <div class="card-header">
            <h4>Añadir Nuevo Ejercicio a la Rutina</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.routines.add_exercise', $rutina->id_rutina) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label for="id_ejercicio">Ejercicio:</label>
                        <select class="form-control" id="id_ejercicio" name="id_ejercicio" required>
                            <option value="">Seleccionar ejercicio...</option>
                            @if(isset($todosLosEjercicios))
                                @foreach ($todosLosEjercicios as $ejercicio_disponible)
                                    <option value="{{ $ejercicio_disponible->id_ejercicio }}" {{ old('id_ejercicio') == $ejercicio_disponible->id_ejercicio ? 'selected' : '' }}>
                                        {{ $ejercicio_disponible->nombre }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('id_ejercicio') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-2 form-group mb-3">
                        <label for="orden">Orden:</label>
                        <input type="number" class="form-control" id="orden" name="orden"
                            value="{{ old('orden', ($rutina->ejercicios->max('pivot.orden') ?? 0) + 1) }}" min="1" required>
                        @error('orden') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group mb-3">
                        <label for="series">Series:</label>
                        <input type="text" class="form-control" id="series" name="series" value="{{ old('series') }}">
                        @error('series') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="repeticiones">Repeticiones:</label>
                        <input type="text" class="form-control" id="repeticiones" name="repeticiones"
                            value="{{ old('repeticiones') }}">
                        @error('repeticiones') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="duracion">Duración (ej. 30s, 1min):</label>
                        <input type="text" class="form-control" id="duracion" name="duracion" value="{{ old('duracion') }}">
                        @error('duracion') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="descanso">Descanso (ej. 60s):</label>
                        <input type="text" class="form-control" id="descanso" name="descanso" value="{{ old('descanso') }}">
                        @error('descanso') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="notas">Notas Adicionales (para este ejercicio en esta rutina):</label>
                    <textarea class="form-control" id="notas" name="notas" rows="2">{{ old('notas') }}</textarea>
                    @error('notas') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-success">Añadir Ejercicio a Rutina</button>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.routines.index') }}" class="btn btn-secondary">Volver al listado de Rutinas</a>
    </div>
@endsection

@push('styles')
    <style>
        .btn-xs {
            /* Clase para botones extra pequeños */
            padding: .1rem .4rem;
            font-size: .75rem;
            line-height: 1.5;
            border-radius: .2rem;
        }

        .table td .btn,
        .table td form {
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .table td form:last-of-type,
        .table td a:last-of-type {
            margin-right: 0;
        }

        .btn-secondary {
            /* Definición si no la tienes en el layout principal */
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            color: #fff;
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
@endpush