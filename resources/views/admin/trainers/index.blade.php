@extends('layouts.admin')

@section('title', 'Gestionar Entrenadores')

@section('page-title', 'Gestión de Entrenadores')

@section('content')
    {{-- Mostrar mensajes de sesión (éxito, error, etc.) --}}
    @if (session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mb-3">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.trainers.create') }}" class="btn btn-primary">Añadir Nuevo Entrenador</a>
    </div>

    @if(isset($trainers) && !$trainers->isEmpty())
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Especialidad</th>
                    <th>Correo Electrónico</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainers as $trainer)
                    <tr>
                        <td>{{ $trainer->id_entrenador }}</td>
                        <td>{{ $trainer->nombre }}</td>
                        <td>{{ $trainer->especialidad }}</td>
                        <td>{{ $trainer->correo }}</td>
                        <td>{{ $trainer->telefono ?? 'N/A' }}</td>
                        <td>
                            {{-- Botón de Editar (AHORA ACTIVO) --}}
                            <a href="{{ route('admin.trainers.edit', $trainer->id_entrenador) }}"
                                class="btn btn-sm btn-warning">Editar</a>

                            {{-- Formulario para Eliminar (sigue activo) --}}
                            <form action="{{ route('admin.trainers.destroy', $trainer->id_entrenador) }}" method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este entrenador? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay entrenadores registrados por el momento.</p>
    @endif
@endsection