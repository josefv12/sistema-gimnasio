@extends('layouts.admin')

@section('title', 'Añadir Nueva Clase Grupal')

@section('page-title', 'Añadir Nueva Clase Grupal')

@section('content')
    <div class="card">
        <div class="card-header">
            Formulario de Nueva Clase Grupal
        </div>
        <div class="card-body">
            {{-- La acción ahora apunta a la ruta 'store' --}}
            <form action="{{ route('admin.group_classes.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="nombre">Nombre de la Clase:</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre"
                        value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                        name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="fecha">Fecha:</label>
                        <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha"
                            value="{{ old('fecha') }}" required>
                        @error('fecha')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="cupo_maximo">Cupo Máximo:</label>
                        <input type="number" class="form-control @error('cupo_maximo') is-invalid @enderror"
                            id="cupo_maximo" name="cupo_maximo" value="{{ old('cupo_maximo') }}" required min="1">
                        @error('cupo_maximo')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="hora_inicio">Hora de Inicio:</label>
                        <input type="time" class="form-control @error('hora_inicio') is-invalid @enderror" id="hora_inicio"
                            name="hora_inicio" value="{{ old('hora_inicio') }}" required>
                        @error('hora_inicio')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="hora_fin">Hora de Fin (Opcional):</label>
                        <input type="time" class="form-control @error('hora_fin') is-invalid @enderror" id="hora_fin"
                            name="hora_fin" value="{{ old('hora_fin') }}">
                        @error('hora_fin')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="id_entrenador">Entrenador Asignado (Opcional):</label>
                    <select class="form-control @error('id_entrenador') is-invalid @enderror" id="id_entrenador"
                        name="id_entrenador">
                        <option value="">Seleccionar Entrenador...</option>
                        @if(isset($trainers))
                            @foreach ($trainers as $trainer)
                                <option value="{{ $trainer->id_entrenador }}" {{ old('id_entrenador') == $trainer->id_entrenador ? 'selected' : '' }}>
                                    {{ $trainer->nombre }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('id_entrenador')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="estado">Estado:</label>
                    <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                        <option value="programada" {{ old('estado', 'programada') == 'programada' ? 'selected' : '' }}>
                            Programada</option>
                        <option value="confirmada" {{ old('estado') == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                        <option value="cancelada" {{ old('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                    @error('estado')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Guardar Clase Grupal</button>
                <a href="{{ route('admin.group_classes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection