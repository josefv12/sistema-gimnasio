@extends('layouts.app')

@section('title', 'Mi Dashboard')

@section('content')
    <h1 class="page-title">Bienvenido a tu Dashboard, {{ $userName ?? 'Cliente' }}</h1>
    <p>Este es tu panel personal. Desde aquí puedes acceder a todas tus actividades.</p>
    <hr>

    {{-- Usamos el sistema de rejilla de Bootstrap para organizar los enlaces --}}
    <div class="row">

        {{-- Tarjeta/Sección para Clases Grupales --}}
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h5 class="card-title">Clases Grupales</h5>
                    <p class="card-text">Explora y únete a nuestras clases disponibles.</p>
                    <a href="{{ route('client.group_classes.list') }}" class="btn btn-primary mt-auto">
                        <i class="bi bi-calendar-event"></i> Ver Clases Disponibles
                    </a>
                </div>
            </div>
        </div>

        {{-- ===== INICIO DE LA MODIFICACIÓN ===== --}}
        {{-- Tarjeta/Sección para Mi Progreso --}}
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h5 class="card-title">Mi Progreso</h5>
                    <p class="card-text">Consulta cómo has mejorado con el tiempo.</p>
                    {{-- Este enlace apunta a la nueva ruta que creamos --}}
                    <a href="{{ route('client.my_progress') }}" class="btn btn-info mt-auto">
                        <i class="bi bi-graph-up"></i> Ver Mi Historial de Progreso
                    </a>
                </div>
            </div>
        </div>
        {{-- ===== FIN DE LA MODIFICACIÓN ===== --}}

    </div>
@endsection

@push('styles')
    <style>
        /* Asegura que las tarjetas en la misma fila tengan la misma altura */
        .card {
            display: flex;
            flex-direction: column;
        }

        .card-body {
            flex-grow: 1;
        }
    </style>
@endpush