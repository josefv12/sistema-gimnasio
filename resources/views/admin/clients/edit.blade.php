@extends('layouts.admin')

@section('title', 'Editar Cliente')

@section('page-title', 'Editar Cliente: ' . $client->nombre)

@section('content')
    <div class="card">
        <div class="card-header">
            Formulario de Edición de Cliente
        </div>
        <div class="card-body">
            {{-- La acción ahora apunta a la ruta 'update' y pasa el ID del cliente --}}
            <form action="{{ route('admin.clients.update', $client->id_cliente) }}" method="POST">
                @csrf
                @method('PUT') {{-- O 'PATCH' --}}

                <div class="form-group mb-3">
                    <label for="nombre">Nombre Completo:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"
                        value="{{ old('nombre', $client->nombre) }}" required>
                    @error('nombre')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="edad">Edad:</label>
                    <input type="number" class="form-control" id="edad" name="edad" value="{{ old('edad', $client->edad) }}"
                        min="1">
                    @error('edad')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="genero">Género:</label>
                    <select class="form-control" id="genero" name="genero">
                        <option value="">Seleccionar...</option>
                        <option value="Masculino" {{ old('genero', $client->genero) == 'Masculino' ? 'selected' : '' }}>
                            Masculino</option>
                        <option value="Femenino" {{ old('genero', $client->genero) == 'Femenino' ? 'selected' : '' }}>Femenino
                        </option>
                        <option value="Otro" {{ old('genero', $client->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('genero')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="correo" name="correo"
                        value="{{ old('correo', $client->correo) }}" required>
                    @error('correo')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" class="form-control" id="telefono" name="telefono"
                        value="{{ old('telefono', $client->telefono) }}">
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

                <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
                <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Cancelar</a>
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