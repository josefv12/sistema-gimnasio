@extends('layouts.admin')

@section('title', 'Añadir Nuevo Entrenador')

@section('page-title', 'Añadir Nuevo Entrenador')

@section('content')
    <div class="card">
        <div class="card-header">
            Formulario de Nuevo Entrenador
        </div>
        <div class="card-body">
            {{-- El action ahora apunta a la ruta 'store' --}}
            <form action="{{ route('admin.trainers.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="nombre">Nombre Completo:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="especialidad">Especialidad:</label>
                    <input type="text" class="form-control" id="especialidad" name="especialidad"
                        value="{{ old('especialidad') }}">
                    @error('especialidad')
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
                    {{-- Laravel buscará este campo automáticamente debido a la regla 'confirmed' en la validación del
                    password --}}
                </div>

                <button type="submit" class="btn btn-primary">Guardar Entrenador</button>
                <a href="{{ route('admin.trainers.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection

{{-- Si quieres usar los estilos que definimos en el layout para .card, .form-control, etc.,
esos ya deberían aplicarse porque están en layouts/admin.blade.php.
Si necesitas estilos MUY específicos para ESTA página, puedes usar @push('styles') aquí,
asumiendo que tienes @stack('styles') en el

<head> de tu layout.
    --}}