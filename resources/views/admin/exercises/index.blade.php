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

    @if(isset($exercises) && !$exercises->isEmpty())
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th> {{-- Ajusta anchos si es necesario --}}
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
                        <td>{{ $exercise->descripcion }}</td> {{-- Quitamos Str::limit --}}
                        <td>{{ $exercise->instrucciones }}</td> {{-- Quitamos Str::limit --}}
                        <td>
                            <a href="{{ route('admin.exercises.edit', $exercise->id_ejercicio) }}"
                                class="btn btn-sm btn-warning mb-1 d-block">Editar</a> {{-- d-block y mb-1 para que los botones
                            estén uno debajo del otro si hay poco espacio --}}
                            <form action="{{ route('admin.exercises.destroy', $exercise->id_ejercicio) }}" method="POST"
                                style="display:inline-block; width:100%;"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este ejercicio? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger d-block w-100">Eliminar</button> {{-- w-100 para
                                que ocupe el ancho, d-block --}}
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