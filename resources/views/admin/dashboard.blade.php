@extends('layouts.admin') {{-- Esto le dice a Blade que use layouts.admin como plantilla --}}

@section('title', 'Dashboard Principal') {{-- Define el título específico para esta página --}}

@section('page-title', 'Dashboard') {{-- Título que aparecerá en la cabecera del contenido --}}

@section('content') {{-- Aquí empieza la sección de contenido principal --}}
    <p>Bienvenido al panel de administración, {{ $userName ?? 'Administrador' }}.</p>
    <p>Desde aquí podrás gestionar los diferentes aspectos del sistema.</p>
    {{-- Puedes añadir más contenido específico del dashboard aquí --}}
@endsection {{-- Aquí termina la sección de contenido --}}