<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rutina;
use App\Models\Entrenador;
use App\Models\Ejercicio;
use App\Models\RutinaEjercicio; // Asegúrate que esta importación esté presente
use Illuminate\Validation\Rule;

class RoutineController extends Controller
{
    public function index()
    {
        $routines = Rutina::with('entrenadorCreador')->orderBy('nombre', 'asc')->paginate(10);
        return view('admin.routines.index', ['routines' => $routines]);
    }

    public function create()
    {
        $trainers = Entrenador::orderBy('nombre')->get();
        return view('admin.routines.create', compact('trainers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150|unique:Rutina,nombre',
            'id_entrenador' => 'nullable|exists:Entrenador,id_entrenador',
        ]);
        if (isset($validatedData['id_entrenador']) && $validatedData['id_entrenador'] === '') {
            $validatedData['id_entrenador'] = null;
        }
        Rutina::create($validatedData);
        return redirect()->route('admin.routines.index')
            ->with('success', '¡Rutina (plantilla) creada exitosamente!');
    }

    public function show(Rutina $rutina)
    {
        $rutina->load('ejercicios');
        $todosLosEjercicios = Ejercicio::orderBy('nombre')->get();
        return view('admin.routines.show', compact('rutina', 'todosLosEjercicios'));
    }

    public function edit(Rutina $rutina)
    {
        $trainers = Entrenador::orderBy('nombre')->get();
        return view('admin.routines.edit', compact('rutina', 'trainers'));
    }

    public function update(Request $request, Rutina $rutina)
    {
        $validatedData = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:150',
                Rule::unique('Rutina', 'nombre')->ignore($rutina->id_rutina, 'id_rutina')
            ],
            'id_entrenador' => 'nullable|exists:Entrenador,id_entrenador',
        ]);
        if (isset($validatedData['id_entrenador']) && $validatedData['id_entrenador'] === '') {
            $validatedData['id_entrenador'] = null;
        }
        $rutina->update($validatedData);
        return redirect()->route('admin.routines.index')
            ->with('success', '¡Rutina (plantilla) actualizada exitosamente!');
    }

    public function destroy(Rutina $rutina)
    {
        try {
            $rutina->ejercicios()->detach();
            $rutina->delete();
            return redirect()->route('admin.routines.index')
                ->with('success', '¡Rutina (plantilla) eliminada exitosamente!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000' || str_contains($e->getMessage(), 'constraint violation')) {
                return redirect()->route('admin.routines.index')
                    ->with('error', 'No se pudo eliminar la rutina. Es posible que esté asignada a uno o más clientes.');
            }
            return redirect()->route('admin.routines.index')
                ->with('error', 'Error al eliminar la rutina: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('admin.routines.index')
                ->with('error', 'Ocurrió un error inesperado al intentar eliminar la rutina.');
        }
    }

    public function addExercise(Request $request, Rutina $rutina)
    {
        $validatedData = $request->validate([
            'id_ejercicio' => 'required|exists:Ejercicio,id_ejercicio',
            'orden' => 'required|integer|min:1',
            'series' => 'nullable|string|max:20',
            'repeticiones' => 'nullable|string|max:20',
            'duracion' => 'nullable|string|max:50',
            'descanso' => 'nullable|string|max:50',
            'notas' => 'nullable|string',
        ]);

        $exists = $rutina->ejercicios()
            ->where('Ejercicio.id_ejercicio', $validatedData['id_ejercicio'])
            ->wherePivot('orden', $validatedData['orden'])
            ->exists();

        if ($exists) {
            return redirect()->route('admin.routines.show', $rutina->id_rutina)
                ->with('exercise_error', 'Este ejercicio ya está asignado a esta rutina con el mismo número de orden.');
        }

        $pivotData = [
            'orden' => $validatedData['orden'],
            'series' => $validatedData['series'],
            'repeticiones' => $validatedData['repeticiones'],
            'duracion' => $validatedData['duracion'],
            'descanso' => $validatedData['descanso'],
            'notas' => $validatedData['notas'],
        ];
        $rutina->ejercicios()->attach($validatedData['id_ejercicio'], $pivotData);
        return redirect()->route('admin.routines.show', $rutina->id_rutina)
            ->with('exercise_success', '¡Ejercicio añadido a la rutina exitosamente!');
    }

    public function removeExercise(Rutina $rutina, Ejercicio $ejercicio)
    {
        $rutina->ejercicios()->detach($ejercicio->id_ejercicio);
        return redirect()->route('admin.routines.show', $rutina->id_rutina)
            ->with('exercise_success', 'Ejercicio quitado de la rutina exitosamente.');
    }

    public function editExerciseDetails(Rutina $rutina, RutinaEjercicio $rutinaEjercicio)
    {
        if ($rutinaEjercicio->id_rutina !== $rutina->id_rutina) {
            abort(404, 'El detalle del ejercicio no pertenece a la rutina especificada.');
        }
        $ejercicio = Ejercicio::find($rutinaEjercicio->id_ejercicio);
        if (!$ejercicio) {
            abort(404, 'Ejercicio asociado no encontrado.');
        }
        return view('admin.routines.edit_exercise_details', compact('rutina', 'rutinaEjercicio', 'ejercicio'));
    }

    /**
     * Actualiza los detalles pivote de un ejercicio en una rutina.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rutina  $rutina
     * @param  \App\Models\RutinaEjercicio  $rutinaEjercicio // El registro de la tabla pivote
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateExerciseDetails(Request $request, Rutina $rutina, RutinaEjercicio $rutinaEjercicio)
    {
        // Asegurarse de que el registro pivote pertenece a la rutina correcta (doble chequeo)
        if ($rutinaEjercicio->id_rutina !== $rutina->id_rutina) {
            abort(403, 'Acción no autorizada.');
        }

        $validatedData = $request->validate([
            'orden' => 'required|integer|min:1',
            'series' => 'nullable|string|max:20',
            'repeticiones' => 'nullable|string|max:20',
            'duracion' => 'nullable|string|max:50',
            'descanso' => 'nullable|string|max:50',
            'notas' => 'nullable|string',
        ]);

        // El método updateExistingPivot actualiza la fila existente en la tabla pivote.
        // El primer argumento es el ID del modelo relacionado (Ejercicio en este caso).
        // El segundo argumento es un array de los atributos pivote a actualizar.
        // No necesitamos 'id_ejercicio' en $validatedData porque no estamos cambiando qué ejercicio es,
        // solo sus atributos en la relación con esta rutina.
        $rutina->ejercicios()->updateExistingPivot($rutinaEjercicio->id_ejercicio, $validatedData);

        return redirect()->route('admin.routines.show', $rutina->id_rutina)
            ->with('exercise_success', 'Detalles del ejercicio en la rutina actualizados exitosamente.');
    }
}