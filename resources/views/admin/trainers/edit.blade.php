@extends('layouts.admin')

@section('title', 'Editar Entrenador')

@section('page-title', 'Editar Entrenador: ' . $trainer->nombre)

@section('content')
    <div class="card">
        <div class="card-header">
            Formulario de Edición de Entrenador
        </div>
        <div class="card-body">
            {{-- La acción ahora apunta a la ruta 'update' y pasa el ID del entrenador --}}
            <form action="{{ route('admin.trainers.update', $trainer->id_entrenador) }}" method="POST">
                @csrf
                @method('PUT') {{-- O 'PATCH' --}}

                <div class="form-group mb-3">
                    <label for="nombre">Nombre Completo:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"
                        value="{{ old('nombre', $trainer->nombre) }}" required>
                    @error('nombre')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="especialidad">Especialidad:</label>
                    <input type="text" class="form-control" id="especialidad" name="especialidad"
                        value="{{ old('especialidad', $trainer->especialidad) }}">
                    @error('especialidad')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="correo" name="correo"
                        value="{{ old('correo', $trainer->correo) }}" required>
                    @error('correo')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" class="form-control" id="telefono" name="telefono"
                        value="{{ old('telefono', $trainer->telefono) }}">
                    @error('telefono')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password">Nueva Contraseña (dejar en blanco para no cambiar):</label>
                    <input type="password" class="form-control" id="password" name="password">
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation">Confirmar Nueva Contraseña:</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Entrenador</button>
                <a href="{{ route('admin.trainers.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection

{{--
@push('styles')
// Si necesitas estilos muy específicos para esta página, puedes añadirlos aquí.
// Los estilos generales para .card, .form-control, .btn, etc., ya están en layouts/admin.blade.php
@endpush
--}}