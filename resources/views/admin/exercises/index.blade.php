@extends('layouts.admin')

@section('title', 'Gestionar Ejercicios')

@section('page-title', 'Gestión de Ejercicios')

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
        <a href="{{ route('admin.exercises.create') }}" class="btn btn-primary">Añadir Nuevo Ejercicio</a>
    </div>

    {{-- ===== INICIO DE LA MODIFICACIÓN ===== --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.exercises.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="search" class="visually-hidden">Buscar</label>
                    <input type="text" class="form-control" id="search" name="search"
                        placeholder="Buscar por nombre o descripción..." value="{{ request('search') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-info">Buscar</button>
                </div>
            </form>
        </div>
    </div>
    {{-- ===== FIN DE LA MODIFICACIÓN ===== --}}

    @if(isset($exercises) && !$exercises->isEmpty())
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 20%;">Nombre</th>
                    <th style="width: 35%;">Descripción</th>
                    <th style="width: 30%;">Instrucciones</th>
                    <th style="width: 10%;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exercises as $exercise)
                    <tr>
                        <td>{{ $exercise->id_ejercicio }}</td>
                        <td>{{ $exercise->nombre }}</td>
                        <td>{{ $exercise->descripcion }}</td>
                        <td>{{ $exercise->instrucciones }}</td>
                        <td>
                            <a href="{{ route('admin.exercises.edit', $exercise->id_ejercicio) }}"
                                class="btn btn-sm btn-warning mb-1 d-block">Editar</a>
                            <form action="{{ route('admin.exercises.destroy', $exercise->id_ejercicio) }}" method="POST"
                                style="display:inline-block; width:100%;"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este ejercicio? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger d-block w-100">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Mostrar enlaces de paginación --}}
        <div class="mt-3">
            {{ $exercises->links() }}
        </div>
    @else
        <p>No hay ejercicios registrados por el momento.</p>
    @endif
@endsection