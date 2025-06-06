@extends('layouts.admin')

@section('title', 'Gestionar Rutinas')

@section('page-title', 'Gestión de Rutinas (Plantillas)')

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
        <a href="{{ route('admin.routines.create') }}" class="btn btn-primary">Añadir Nueva Rutina</a>
    </div>

    @if(isset($routines) && !$routines->isEmpty())
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Creador</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($routines as $routine)
                    <tr>
                        <td>{{ $routine->id_rutina }}</td>
                        <td>{{ $routine->nombre }}</td>
                        <td>{{ $routine->entrenadorCreador->nombre ?? 'Sistema / N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.routines.edit', $routine->id_rutina) }}"
                                class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('admin.routines.destroy', $routine->id_rutina) }}" method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta rutina? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                            {{-- Enlace para Ver/Asignar Ejercicios (MOVIDO AL FINAL) --}}
                            <a href="{{ route('admin.routines.show', $routine->id_rutina) }}"
                                class="btn btn-sm btn-info">Ver/Asignar Ejercicios</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $routines->links() }}
        </div>
    @else
        <p>No hay rutinas (plantillas) registradas por el momento.</p>
    @endif
@endsection

{{-- Estilos CSS (asegúrate de que .btn-info esté definido en tu layout o aquí) --}}
@push('styles')
    <style>
        /* ... (tus estilos existentes para .table, .btn, .alert, etc.) ... */

        /* Para que los botones de acción estén un poco más separados si van en la misma línea */
        .table td .btn,
        .table td form {
            margin-right: 5px;
            /* Espacio a la derecha de cada botón/formulario */
            margin-bottom: 5px;
            /* Espacio debajo si se ajustan a una nueva línea */
        }

        .table td form:last-of-type,
        /* Ajuste para el último formulario si es el último elemento inline */
        .table td a:last-of-type {
            /* Ajuste para el último enlace si es el último elemento inline */
            margin-right: 0;
        }
    </style>
@endpush