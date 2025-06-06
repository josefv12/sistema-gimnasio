@extends('layouts.admin')

@section('title', 'Añadir Nueva Rutina')

@section('page-title', 'Añadir Nueva Rutina (Plantilla)')

@section('content')
    <div class="card">
        <div class="card-header">
            Formulario de Nueva Rutina
        </div>
        <div class="card-body">
            {{-- La acción ahora apunta a la ruta 'store' --}}
            <form action="{{ route('admin.routines.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="nombre">Nombre de la Rutina:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Si decides añadir descripción, objetivo, nivel, aquí irían esos campos.
                Asegúrate de que también estén en la migración y en el $fillable del modelo Rutina.
                Y añade las reglas de validación correspondientes en el RoutineController@store.
                --}}
                {{--
                <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion"
                        rows="3">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="objetivo">Objetivo:</label>
                    <input type="text" class="form-control" id="objetivo" name="objetivo" value="{{ old('objetivo') }}">
                    @error('objetivo')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="nivel">Nivel:</label>
                    <select class="form-control" id="nivel" name="nivel">
                        <option value="">Seleccionar nivel...</option>
                        <option value="Principiante" {{ old('nivel')=='Principiante' ? 'selected' : '' }}>Principiante
                        </option>
                        <option value="Intermedio" {{ old('nivel')=='Intermedio' ? 'selected' : '' }}>Intermedio</option>
                        <option value="Avanzado" {{ old('nivel')=='Avanzado' ? 'selected' : '' }}>Avanzado</option>
                    </select>
                    @error('nivel')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                --}}

                <div class="form-group mb-3">
                    <label for="id_entrenador">Entrenador Creador (Opcional):</label>
                    <select class="form-control" id="id_entrenador" name="id_entrenador">
                        <option value="">Ninguno / Sistema</option>
                        @if(isset($trainers)) {{-- Asegurarse que $trainers existe --}}
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

                <button type="submit" class="btn btn-primary">Guardar Rutina</button>
                <a href="{{ route('admin.routines.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection