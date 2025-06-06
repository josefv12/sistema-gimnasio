@extends('layouts.admin')

@section('title', 'Añadir Nuevo Tipo de Membresía')

@section('page-title', 'Añadir Nuevo Tipo de Membresía')

@section('content')
    <div class="card">
        <div class="card-header">
            Formulario de Nuevo Tipo de Membresía
        </div>
        <div class="card-body">
            {{-- El action ahora apunta a la ruta 'store' --}}
            <form action="{{ route('admin.membership_types.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="nombre">Nombre del Tipo de Membresía:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion"
                        rows="3">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="duracion_dias">Duración (en días):</label>
                    <input type="number" class="form-control" id="duracion_dias" name="duracion_dias"
                        value="{{ old('duracion_dias') }}" required min="1">
                    @error('duracion_dias')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="precio">Precio:</label>
                    <input type="number" class="form-control" id="precio" name="precio" value="{{ old('precio') }}" required
                        step="0.01" min="0">
                    @error('precio')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="estado">Estado:</label>
                    <select class="form-control" id="estado" name="estado" required>
                        <option value="activo" {{ old('estado', 'activo') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Guardar Tipo de Membresía</button>
                <a href="{{ route('admin.membership_types.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection

{{-- Si quieres estilos básicos para el formulario, y tienes @stack('styles') en tu layout --}}
@push('styles')
    <style>
        .card {
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
            margin-bottom: 1rem;
        }

        .card-header {
            padding: .75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, .03);
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        .card-body {
            padding: 1.25rem;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            box-sizing: border-box;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .mt-1 {
            margin-top: .25rem !important;
        }

        /* mb-3 ya está definido en el CSS del layout para la tabla, pero no hace daño tenerlo aquí si se necesita específicamente para el formulario */
        /* .mb-3 { margin-bottom: 1rem !important; } */
        .btn {
            display: inline-block;
            font-weight: 400;
            /* color: #212529; */
            /* Color por defecto de Bootstrap, puedes ajustarlo */
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }
    </style>
@endpush