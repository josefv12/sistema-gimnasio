@extends('layouts.admin')

@section('title', 'Asignar Membresía')

@section('page-title', 'Asignar Nueva Membresía')

@section('content')

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Asignando a: <strong>{{ $cliente->nombre }}</strong></h5>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted">
                        Completa el formulario para activar una nueva membresía para este cliente. La fecha de fin se
                        calculará automáticamente.
                    </p>

                    <form action="{{ route('admin.clients.memberships.store', $cliente->id_cliente) }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Columna para el Tipo de Membresía --}}
                            <div class="col-md-8 mb-3">
                                <label for="id_tipo_membresia" class="form-label"><strong>Plan de
                                        Membresía:</strong></label>
                                <select class="form-select @error('id_tipo_membresia') is-invalid @enderror"
                                    id="id_tipo_membresia" name="id_tipo_membresia" required>
                                    <option value="" disabled selected>-- Selecciona un plan --</option>
                                    @foreach ($tiposMembresia as $tipo)
                                        <option value="{{ $tipo->id_tipo_membresia }}" {{ old('id_tipo_membresia') == $tipo->id_tipo_membresia ? 'selected' : '' }}>
                                            {{ $tipo->nombre }} (${{ number_format($tipo->precio, 0, ',', '.') }}) -
                                            {{ $tipo->duracion_dias }} días
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_tipo_membresia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Columna para la Fecha de Inicio --}}
                            <div class="col-md-4 mb-3">
                                <label for="fecha_inicio" class="form-label"><strong>Fecha de Inicio:</strong></label>
                                <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror"
                                    id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio', date('Y-m-d')) }}"
                                    required>
                                @error('fecha_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Aquí podríamos añadir campos para un pago inicial si se requiere --}}

                        <hr class="my-4">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.clients.show', $cliente->id_cliente) }}"
                                class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success"><i
                                    class="bi bi-check-circle-fill me-2"></i>Guardar y Activar Membresía</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection