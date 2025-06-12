<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ejercicio;
use Illuminate\Validation\Rule;

class ExerciseController extends Controller
{
    // ===== INICIO DE LA MODIFICACIÓN =====
    public function index(Request $request)
    {
        // 1. Empezamos una consulta base con el modelo Ejercicio.
        $query = Ejercicio::query();

        // 2. Usamos when() para aplicar un filtro SÓLO SI existe un input 'search' en la URL.
        $query->when($request->input('search'), function ($q, $search) {
            // Buscamos el término en las columnas 'nombre' Y 'descripcion'.
            return $q->where('nombre', 'like', "%{$search}%")
                ->orWhere('descripcion', 'like', "%{$search}%");
        });

        // 3. Ordenamos y paginamos el resultado de la consulta (ya sea la original o la filtrada).
        $exercises = $query->orderBy('nombre', 'asc')->paginate(10);

        return view('admin.exercises.index', compact('exercises'));
    }
    // ===== FIN DE LA MODIFICACIÓN =====

    public function create()
    {
        return view('admin.exercises.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:Ejercicio,nombre',
            'descripcion' => 'nullable|string',
            'instrucciones' => 'nullable|string',
        ]);

        Ejercicio::create($validatedData);

        return redirect()->route('admin.exercises.index')
            ->with('success', '¡Ejercicio creado exitosamente!');
    }

    public function edit(Ejercicio $ejercicio)
    {
        return view('admin.exercises.edit', ['exercise' => $ejercicio]);
    }

    public function update(Request $request, Ejercicio $ejercicio)
    {
        $validatedData = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('Ejercicio', 'nombre')->ignore($ejercicio->id_ejercicio, 'id_ejercicio')
            ],
            'descripcion' => 'nullable|string',
            'instrucciones' => 'nullable|string',
        ]);

        $ejercicio->update($validatedData);

        return redirect()->route('admin.exercises.index')
            ->with('success', '¡Ejercicio actualizado exitosamente!');
    }

    /**
     * Elimina un ejercicio específico de la base de datos.
     *
     * @param  \App\Models\Ejercicio  $ejercicio // Route Model Binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Ejercicio $ejercicio)
    {
        try {
            // Antes de eliminar, considera las relaciones.
            // Si un ejercicio está en uso en alguna Rutina_Ejercicio,
            // la restricción de FK 'ON DELETE RESTRICT' que definimos en la migración de Rutina_Ejercicio
            // impedirá la eliminación directa del ejercicio.
            // Deberías manejar esto, quizás desasociando el ejercicio de todas las rutinas
            // o informando al usuario que no se puede eliminar porque está en uso.

            // Para una eliminación simple (fallará si hay FK con RESTRICT):
            $ejercicio->delete();

            return redirect()->route('admin.exercises.index')
                ->with('success', '¡Ejercicio eliminado exitosamente!');

        } catch (\Illuminate\Database\QueryException $e) {
            // Capturar excepciones de consulta, comúnmente por restricciones de clave foránea
            if ($e->getCode() === '23000' || str_contains($e->getMessage(), 'constraint violation')) {
                // Código '23000' es SQLSTATE para violación de integridad, común para FK.
                return redirect()->route('admin.exercises.index')
                    ->with('error', 'No se pudo eliminar el ejercicio. Es posible que esté asignado a una o más rutinas.');
            }
            return redirect()->route('admin.exercises.index')
                ->with('error', 'Error al eliminar el ejercicio: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('admin.exercises.index')
                ->with('error', 'Ocurrió un error inesperado al intentar eliminar el ejercicio.');
        }
    }
}