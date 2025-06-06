@extends('layouts.admin')

@section('title', 'Editar Ejercicio')

@section('page-title', 'Editar Ejercicio: ' . $exercise->nombre)

@section('content')
    <div class="card">
        <div class="card-header">
            Formulario de Edición de Ejercicio
        </div>
        <div class="card-body">
            {{-- La acción ahora apunta a la ruta 'update' y pasa el ID del ejercicio --}}
            <form action="{{ route('admin.exercises.update', $exercise->id_ejercicio) }}" method="POST">
                @csrf
                @method('PUT') {{-- O 'PATCH' --}}

                <div class="form-group mb-3">
                    <label for="nombre">Nombre del Ejercicio:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"
                        value="{{ old('nombre', $exercise->nombre) }}" required>
                    @error('nombre')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion"
                        rows="3">{{ old('descripcion', $exercise->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="instrucciones">Instrucciones:</label>
                    <textarea class="form-control" id="instrucciones" name="instrucciones"
                        rows="5">{{ old('instrucciones', $exercise->instrucciones) }}</textarea>
                    @error('instrucciones')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Aquí podrías añadir más campos si los definiste en la migración, como:
                <div class="form-group mb-3">
                    <label for="grupo_muscular_principal">Grupo Muscular Principal:</label>
                    <input type="text" class="form-control" id="grupo_muscular_principal" name="grupo_muscular_principal"
                        value="{{ old('grupo_muscular_principal', $exercise->grupo_muscular_principal ?? '') }}">
                    @error('grupo_muscular_principal')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="equipamiento_requerido">Equipamiento Requerido:</label>
                    <input type="text" class="form-control" id="equipamiento_requerido" name="equipamiento_requerido"
                        value="{{ old('equipamiento_requerido', $exercise->equipamiento_requerido ?? '') }}">
                    @error('equipamiento_requerido')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                --}}

                <button type="submit" class="btn btn-primary">Actualizar Ejercicio</button>
                <a href="{{ route('admin.exercises.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection