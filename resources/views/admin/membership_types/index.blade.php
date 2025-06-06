@extends('layouts.admin')

@section('title', 'Gestionar Tipos de Membresía')

@section('page-title', 'Gestión de Tipos de Membresía')

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
        <a href="{{ route('admin.membership_types.create') }}" class="btn btn-primary">Añadir Nuevo Tipo de Membresía</a>
    </div>

    @if(isset($membershipTypes) && !$membershipTypes->isEmpty())
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Duración (Días)</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($membershipTypes as $type)
                    <tr>
                        <td>{{ $type->id_tipo_membresia }}</td>
                        <td>{{ $type->nombre }}</td>
                        <td>{{ $type->descripcion }}</td>
                        <td>{{ $type->duracion_dias }}</td>
                        <td>${{ number_format($type->precio, 2, ',', '.') }}</td>
                        <td>{{ ucfirst($type->estado) }}</td>
                        <td>
                            <a href="{{ route('admin.membership_types.edit', $type->id_tipo_membresia) }}"
                                class="btn btn-sm btn-warning">Editar</a>
                            {{-- Formulario para el botón de eliminar --}}
                            <form action="{{ route('admin.membership_types.destroy', $type->id_tipo_membresia) }}" method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este tipo de membresía? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- {{ $membershipTypes->links() }} --}}
    @else
        <p>No hay tipos de membresía registrados por el momento.</p>
    @endif
@endsection

@push('styles')
    <style>
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            background-color: #e9ecef;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, .05);
        }

        .table-hover tbody tr:hover {
            color: #212529;
            background-color: rgba(0, 0, 0, .075);
        }

        .btn {
            display: inline-block;
            font-weight: 400;
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

        .btn-warning {
            color: #212529;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* Estilo para Eliminar */
        .btn-sm {
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .alert {
            position: relative;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        /* Estilo para mensajes de error */
    </style>
@endpush