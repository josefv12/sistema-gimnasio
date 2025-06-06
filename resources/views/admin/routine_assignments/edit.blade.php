@extends('layouts.admin')

@section('title', 'Editar Asignación de Rutina')

@section('page-title', 'Editar Asignación de Rutina')

@section('content')
    <div class="card">
        <div class="card-header">
            Formulario de Edición de Asignación de Rutina
        </div>
        <div class="card-body">
            {{-- La acción ahora apunta a la ruta 'update' y pasa el ID de la asignación --}}
            <form action="{{ route('admin.routine_assignments.update', $assignment->id_asignacion) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label>Cliente:</label>
                    <input type="text" class="form-control"
                        value="{{ $assignment->cliente->nombre ?? 'N/A' }} (ID: {{ $assignment->id_cliente }})" readonly>
                    {{-- Si permitieras cambiar el cliente, usarías un select como en el formulario de creación --}}
                    {{-- <input type="hidden" name="id_cliente" value="{{ $assignment->id_cliente }}"> --}}
                </div>

                <div class="form-group mb-3">
                    <label>Rutina (Plantilla):</label>
                    <input type="text" class="form-control"
                        value="{{ $assignment->rutina->nombre ?? 'N/A' }} (ID: {{ $assignment->id_rutina }})" readonly>
                    {{-- Si permitieras cambiar la rutina, usarías un select --}}
                    {{-- <input type="hidden" name="id_rutina" value="{{ $assignment->id_rutina }}"> --}}
                </div>

                <div class="form-group mb-3">
                    <label for="id_entrenador">Entrenador que Asignó (Opcional):</label>
                    <select class="form-control @error('id_entrenador') is-invalid @enderror" id="id_entrenador"
                        name="id_entrenador">
                        <option value="">Sistema / Administrador Actual</option>
                        @foreach ($trainers as $trainer)
                            <option value="{{ $trainer->id_entrenador }}" {{ old('id_entrenador', $assignment->id_entrenador) == $trainer->id_entrenador ? 'selected' : '' }}>
                                {{ $trainer->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_entrenador')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="fecha_asignacion">Fecha de Asignación:</label>
                    <input type="datetime-local" class="form-control @error('fecha_asignacion') is-invalid @enderror"
                        id="fecha_asignacion" name="fecha_asignacion"
                        value="{{ old('fecha_asignacion', $assignment->fecha_asignacion->format('Y-m-d\TH:i')) }}" required>
                    @error('fecha_asignacion')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="estado">Estado de la Asignación:</label>
                    <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                        <option value="activa" {{ old('estado', $assignment->estado) == 'activa' ? 'selected' : '' }}>Activa
                        </option>
                        <option value="completada" {{ old('estado', $assignment->estado) == 'completada' ? 'selected' : '' }}>
                            Completada</option>
                        <option value="cancelada" {{ old('estado', $assignment->estado) == 'cancelada' ? 'selected' : '' }}>
                            Cancelada</option>
                    </select>
                    @error('estado')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="notas_entrenador">Notas del Entrenador (Opcional):</label>
                    <textarea class="form-control @error('notas_entrenador') is-invalid @enderror" id="notas_entrenador"
                        name="notas_entrenador"
                        rows="3">{{ old('notas_entrenador', $assignment->notas_entrenador) }}</textarea>
                    @error('notas_entrenador')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Asignación</button>
                <a href="{{ route('admin.routine_assignments.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection