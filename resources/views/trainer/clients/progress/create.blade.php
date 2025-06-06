@extends('layouts.trainer')

@section('title', 'Registrar Progreso para ' . $cliente->nombre)

@section('page-title', 'Registrar Nuevo Progreso para: ' . $cliente->nombre)

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Nuevo Registro de Progreso</h5>
        </div>
        <div class="card-body">
            {{-- La acción ahora apunta a la ruta 'store' del progreso del cliente --}}
            <form action="{{ route('trainer.clients.progress.store', $cliente->id_cliente) }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="fecha">Fecha de Medición:</label>
                    <input type="datetime-local" class="form-control @error('fecha') is-invalid @enderror" id="fecha"
                        name="fecha" value="{{ old('fecha', now()->format('Y-m-d\TH:i')) }}" required>
                    @error('fecha')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="peso">Peso (kg):</label>
                        <input type="number" step="0.01" class="form-control @error('peso') is-invalid @enderror" id="peso"
                            name="peso" value="{{ old('peso') }}">
                        @error('peso')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Si decides añadir porcentaje_grasa_corporal como campo separado:
                    <div class="col-md-6 form-group mb-3">
                        <label for="porcentaje_grasa_corporal">% Grasa Corporal:</label>
                        <input type="number" step="0.01"
                            class="form-control @error('porcentaje_grasa_corporal') is-invalid @enderror"
                            id="porcentaje_grasa_corporal" name="porcentaje_grasa_corporal"
                            value="{{ old('porcentaje_grasa_corporal') }}">
                        @error('porcentaje_grasa_corporal')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    --}}
                </div>

                <div class="form-group mb-3">
                    <label for="medidas">Medidas Adicionales (ej. cintura, cadera, % grasa, etc.):</label>
                    <textarea class="form-control @error('medidas') is-invalid @enderror" id="medidas" name="medidas"
                        rows="3">{{ old('medidas') }}</textarea>
                    @error('medidas')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="rendimiento_notas">Notas de Rendimiento:</label>
                    <textarea class="form-control @error('rendimiento_notas') is-invalid @enderror" id="rendimiento_notas"
                        name="rendimiento_notas" rows="4">{{ old('rendimiento_notas') }}</textarea>
                    @error('rendimiento_notas')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="id_asignacion">Asociar a Rutina Asignada (Opcional):</label>
                    <select class="form-control @error('id_asignacion') is-invalid @enderror" id="id_asignacion"
                        name="id_asignacion">
                        <option value="">Ninguna</option>
                        @if(isset($activeRoutineAssignments) && !$activeRoutineAssignments->isEmpty())
                            @foreach ($activeRoutineAssignments as $assignment)
                                <option value="{{ $assignment->id_asignacion }}" {{ old('id_asignacion') == $assignment->id_asignacion ? 'selected' : '' }}>
                                    {{ $assignment->rutina->nombre ?? 'Rutina Desconocida' }} (Asignada el:
                                    {{ $assignment->fecha_asignacion->format('d/m/Y') }})
                                </option>
                            @endforeach
                        @else
                            <option value="" disabled>No hay rutinas activas asignadas a este cliente.</option>
                        @endif
                    </select>
                    @error('id_asignacion')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Guardar Progreso</button>
                <a href="{{ route('trainer.clients.progress_tracking', $cliente->id_cliente) }}"
                    class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection