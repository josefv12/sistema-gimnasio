@extends('layouts.trainer')

@section('title', 'Dashboard Entrenador')

@section('page-title', 'Dashboard Principal') {{-- Título que aparecerá en la cabecera del contenido --}}

@section('content')
    <div class="alert alert-info">
        <h4 class="alert-heading">¡Bienvenido, {{ $userName ?? 'Entrenador' }}!</h4>
        <p>Este es tu panel personal. Desde aquí podrás gestionar tus clases, ver tus clientes asignados y mucho más.</p>
        <hr>
        <p class="mb-0">Utiliza el menú de la izquierda para navegar por las diferentes secciones.</p>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Mis Clases Programadas</h5>
                    <p class="card-text">Visualiza y gestiona las clases que tienes asignadas.</p>
                    <a href="{{ route('trainer.my_classes.list') }}" class="btn btn-primary"><i
                            class="bi bi-calendar-check-fill me-2"></i>Ir a Mis Clases</a>
                </div>
            </div>
        </div>
        {{-- Aquí podrías añadir más tarjetas para otras funcionalidades del entrenador --}}
        {{--
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Mis Clientes</h5>
                    <p class="card-text">Consulta la lista de clientes que tienes a tu cargo.</p>
                    <a href="#" class="btn btn-primary"><i class="bi bi-people-fill me-2"></i>Ver Mis Clientes</a>
                </div>
            </div>
        </div>
        --}}
    </div>
@endsection