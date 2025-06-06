@extends('layouts.admin')

@section('title', 'Editar Detalles de Ejercicio en Rutina')

@section('page-title', 'Editar Detalles: ' . ($ejercicio->nombre ?? 'Ejercicio') . ' en Rutina: ' . $rutina->nombre)

@section('content')
    <div class="card">
        <div class="card-header">
            Modificar detalles para: <strong>{{ $ejercicio->nombre ?? 'Ejercicio Desconocido' }}</strong>
        </div>
        <div class="card-body">
            {{-- La acción ahora apunta a la ruta 'update_exercise_details' --}}
            <form
                action="{{ route('admin.routines.update_exercise_details', ['rutina' => $rutina->id_rutina, 'rutinaEjercicio' => $rutinaEjercicio->id_rutina_ejercicio]) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="orden">Orden:</label>
                    <input type="number" class="form-control" id="orden" name="orden"
                        value="{{ old('orden', $rutinaEjercicio->orden) }}" min="1" required>
                    @error('orden') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-3 form-group mb-3">
                        <label for="series">Series:</label>
                        <input type="text" class="form-control" id="series" name="series"
                            value="{{ old('series', $rutinaEjercicio->series) }}">
                        @error('series') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="repeticiones">Repeticiones:</label>
                        <input type="text" class="form-control" id="repeticiones" name="repeticiones"
                            value="{{ old('repeticiones', $rutinaEjercicio->repeticiones) }}">
                        @error('repeticiones') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="duracion">Duración (ej. 30s, 1min):</label>
                        <input type="text" class="form-control" id="duracion" name="duracion"
                            value="{{ old('duracion', $rutinaEjercicio->duracion) }}">
                        @error('duracion') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3 form-group mb-3">
                        <label for="descanso">Descanso (ej. 60s):</label>
                        <input type="text" class="form-control" id="descanso" name="descanso"
                            value="{{ old('descanso', $rutinaEjercicio->descanso) }}">
                        @error('descanso') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="notas">Notas Adicionales:</label>
                    <textarea class="form-control" id="notas" name="notas"
                        rows="2">{{ old('notas', $rutinaEjercicio->notas) }}</textarea>
                    @error('notas') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Detalles del Ejercicio</button>
                <a href="{{ route('admin.routines.show', $rutina->id_rutina) }}" class="btn btn-secondary">Cancelar y Volver
                    a la Rutina</a>
            </form>
        </div>
    </div>
@endsection