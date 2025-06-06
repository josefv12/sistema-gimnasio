<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ejercicio;
use Illuminate\Validation\Rule;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Ejercicio::orderBy('nombre', 'asc')->paginate(10);
        return view('admin.exercises.index', ['exercises' => $exercises]);
    }

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