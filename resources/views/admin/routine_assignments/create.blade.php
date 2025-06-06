@extends('layouts.admin')

@section('title', 'Asignar Nueva Rutina a Cliente')

@section('page-title', 'Asignar Nueva Rutina a Cliente')

@section('content')
    <div class="card">
        <div class="card-header">
            Formulario de Nueva Asignación de Rutina
        </div>
        <div class="card-body">
            {{-- La acción ahora apunta a la ruta 'store' --}}
            <form action="{{ route('admin.routine_assignments.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="id_cliente">Cliente:</label>
                    <select class="form-control @error('id_cliente') is-invalid @enderror" id="id_cliente" name="id_cliente" required>
                        <option value="">Seleccionar Cliente...</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id_cliente }}" {{ old('id_cliente') == $client->id_cliente ? 'selected' : '' }}>
                                {{ $client->nombre }} (ID: {{ $client->id_cliente }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_cliente')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="id_rutina">Rutina (Plantilla):</label>
                    <select class="form-control @error('id_rutina') is-invalid @enderror" id="id_rutina" name="id_rutina" required>
                        <option value="">Seleccionar Rutina...</option>
                        @foreach ($routines as $routine)
                            <option value="{{ $routine->id_rutina }}" {{ old('id_rutina') == $routine->id_rutina ? 'selected' : '' }}>
                                {{ $routine->nombre }} (ID: {{ $routine->id_rutina }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_rutina')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="id_entrenador">Entrenador que Asigna (Opcional):</label>
                    <select class="form-control @error('id_entrenador') is-invalid @enderror" id="id_entrenador" name="id_entrenador">
                        <option value="">Sistema / Administrador Actual</option>
                        @foreach ($trainers as $trainer)
                            <option value="{{ $trainer->id_entrenador }}" {{ old('id_entrenador') == $trainer->id_entrenador ? 'selected' : '' }}>
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
                    <input type="datetime-local" class="form-control @error('fecha_asignacion') is-invalid @enderror" id="fecha_asignacion" name="fecha_asignacion" value="{{ old('fecha_asignacion', now()->format('Y-m-d\TH:i')) }}" required>
                    @error('fecha_asignacion')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="estado">Estado de la Asignación:</label>
                    <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                        <option value="activa" {{ old('estado', 'activa') == 'activa' ? 'selected' : '' }}>Activa</option>
                        <option value="completada" {{ old('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                        <option value="cancelada" {{ old('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                    @error('estado')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="notas_entrenador">Notas del Entrenador (Opcional):</label>
                    <textarea class="form-control @error('notas_entrenador') is-invalid @enderror" id="notas_entrenador" name="notas_entrenador" rows="3">{{ old('notas_entrenador') }}</textarea>
                    @error('notas_entrenador')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Guardar Asignación</button>
                <a href="{{ route('admin.routine_assignments.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection