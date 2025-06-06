@extends('layouts.admin')

@section('title', 'Editar Rutina')

@section('page-title', 'Editar Rutina (Plantilla): ' . $rutina->nombre)

@section('content')
    <div class="card">
        <div class="card-header">
            Formulario de Edición de Rutina
        </div>
        <div class="card-body">
            {{-- La acción ahora apunta a la ruta 'update' y pasa el ID de la rutina --}}
            <form action="{{ route('admin.routines.update', $rutina->id_rutina) }}" method="POST">
                @csrf
                @method('PUT') {{-- O 'PATCH' --}}

                <div class="form-group mb-3">
                    <label for="nombre">Nombre de la Rutina:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"
                        value="{{ old('nombre', $rutina->nombre) }}" required>
                    @error('nombre')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Si decides añadir descripción, objetivo, nivel, aquí irían esos campos.
                Asegúrate de que también estén en la migración y en el $fillable del modelo Rutina.
                Y añade las reglas de validación correspondientes en el RoutineController@update.
                --}}
                {{--
                <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion"
                        rows="3">{{ old('descripcion', $rutina->descripcion) }}</textarea>
                    @error('descripcion')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="objetivo">Objetivo:</label>
                    <input type="text" class="form-control" id="objetivo" name="objetivo"
                        value="{{ old('objetivo', $rutina->objetivo) }}">
                    @error('objetivo')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="nivel">Nivel:</label>
                    <select class="form-control" id="nivel" name="nivel">
                        <option value="">Seleccionar nivel...</option>
                        <option value="Principiante" {{ old('nivel', $rutina->nivel ?? '') == 'Principiante' ? 'selected' :
                            '' }}>Principiante</option>
                        <option value="Intermedio" {{ old('nivel', $rutina->nivel ?? '') == 'Intermedio' ? 'selected' : ''
                            }}>Intermedio</option>
                        <option value="Avanzado" {{ old('nivel', $rutina->nivel ?? '') == 'Avanzado' ? 'selected' : ''
                            }}>Avanzado</option>
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
                                <option value="{{ $trainer->id_entrenador }}" {{ old('id_entrenador', $rutina->id_entrenador) == $trainer->id_entrenador ? 'selected' : '' }}>
                                    {{ $trainer->nombre }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('id_entrenador')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Rutina</button>
                <a href="{{ route('admin.routines.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
    <hr>
    {{-- SECCIÓN PARA ASIGNAR EJERCICIOS A ESTA RUTINA (FUNCIONALIDAD FUTURA) --}}
    {{-- <h3>Ejercicios en esta Rutina</h3> --}}
    {{-- Aquí iría una tabla con los ejercicios ya asignados y un formulario para añadir más --}}
    {{-- <p><em>La funcionalidad para asignar ejercicios a esta rutina se implementará en un paso posterior.</em></p> --}}

@endsection