@extends('layouts.admin')

@section('title', 'Añadir Nuevo Cliente')

@section('page-title', 'Añadir Nuevo Cliente')

@section('content')
    <div class="card">
        <div class="card-header">
            Formulario de Nuevo Cliente
        </div>
        <div class="card-body">
            {{-- El action ahora apunta a la ruta 'store' --}}
            <form action="{{ route('admin.clients.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="nombre">Nombre Completo:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="edad">Edad:</label>
                    <input type="number" class="form-control" id="edad" name="edad" value="{{ old('edad') }}" min="1">
                    @error('edad')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="genero">Género:</label>
                    <select class="form-control" id="genero" name="genero">
                        <option value="">Seleccionar...</option>
                        <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('genero')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo') }}" required>
                    @error('correo')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}">
                    @error('telefono')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation">Confirmar Contraseña:</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection