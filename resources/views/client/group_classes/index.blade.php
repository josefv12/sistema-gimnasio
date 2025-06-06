@extends('layouts.app') {{-- Asegúrate que este sea tu layout principal para clientes --}}

@section('title', 'Clases Grupales Disponibles')

@section('content')
<div class="container"> {{-- Contenedor principal de Bootstrap --}}
    <h1 class="page-title">Clases Grupales Disponibles</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($availableClasses) && !$availableClasses->isEmpty())
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($availableClasses as $class)
                <div class="col">
                    <div class="card h-100 shadow-sm"> {{-- Tarjeta con altura 100% y sombra --}}
                        <div class="card-body d-flex flex-column"> {{-- flex-column para alinear el botón de reservar abajo --}}
                            <h5 class="card-title text-primary">{{ $class->nombre }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <i class="bi bi-calendar-event"></i> {{ $class->fecha->format('d/m/Y') }} |
                                <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($class->hora_inicio)->format('h:i A') }}
                                {{ $class->hora_fin ? ' - ' . \Carbon\Carbon::parse($class->hora_fin)->format('h:i A') : '' }}
                            </h6>
                            <p class="card-text flex-grow-1">{{ Str::limit($class->descripcion ?? 'Sin descripción.', 120) }}</p>
                            <div class="mt-auto"> {{-- Empuja el contenido de abajo hacia el final de la tarjeta --}}
                                <p class="card-text">
                                    <small class="text-muted">
                                        <i class="bi bi-person"></i> Entrenador: {{ $class->entrenador->nombre ?? 'No asignado' }}<br>
                                        <i class="bi bi-people"></i> Cupos máximos: {{ $class->cupo_maximo }}
                                        {{-- Aquí podrías añadir lógica para mostrar cupos disponibles si la pasas desde el controlador --}}
                                        {{-- Ejemplo: | Cupos disponibles: {{ $class->cupos_disponibles_calculados }} --}}
                                    </small>
                                </p>
                                <form action="{{ route('client.group_classes.book', $class->id_clase) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100"><i class="bi bi-check-circle"></i> Reservar Cupo</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $availableClasses->links() }} {{-- Paginación estilizada por Bootstrap --}}
        </div>
    @else
        <div class="alert alert-info mt-3">
            No hay clases grupales disponibles programadas por el momento.
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left-circle"></i> Volver al Dashboard</a>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Estilos para la página del cliente (si no están ya en layouts.app) */
    .page-title { /* Lo definimos en layouts.app, pero por si acaso */
        color: #343a40;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #007bff;
        padding-bottom: 0.5rem;
        display: inline-block;
    }
    .card-title.text-primary {
        color: #007bff !important; /* Asegurar que se aplique si es necesario */
    }
    /* Estilos para los botones si no están cubiertos por Bootstrap en tu layout principal */
    .btn-success {
        color: #fff;
        background-color: #198754; /* Un verde Bootstrap más común para éxito */
        border-color: #198754;
    }
    .btn-success:hover {
        background-color: #157347;
        border-color: #146c43;
    }
    .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
    }
    .btn-outline-secondary:hover {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }
</style>
@endpush