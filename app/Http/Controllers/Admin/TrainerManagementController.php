<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entrenador;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // Necesario para la regla unique al actualizar
use Illuminate\Validation\Rules\Password;

class TrainerManagementController extends Controller
{
    public function index()
    {
        $trainers = Entrenador::all();
        return view('admin.trainers.index', ['trainers' => $trainers]);
    }

    public function create()
    {
        return view('admin.trainers.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150',
            'especialidad' => 'nullable|string|max:100',
            'correo' => 'required|string|email|max:255|unique:Entrenador,correo',
            'telefono' => 'nullable|string|max:30',
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ]);

        $trainer = Entrenador::create([
            'nombre' => $validatedData['nombre'],
            'especialidad' => $validatedData['especialidad'],
            'correo' => $validatedData['correo'],
            'telefono' => $validatedData['telefono'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $trainer->assignRole('entrenador');

        return redirect()->route('admin.trainers.index')
            ->with('success', '¡Entrenador creado exitosamente!');
    }

    public function edit(Entrenador $entrenador)
    {
        return view('admin.trainers.edit', ['trainer' => $entrenador]);
    }

    /**
     * Actualiza un entrenador existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entrenador  $entrenador // Route Model Binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Entrenador $entrenador)
    {
        // 1. Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150',
            'especialidad' => 'nullable|string|max:100',
            'correo' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('Entrenador', 'correo')->ignore($entrenador->id_entrenador, 'id_entrenador') // Ignora el registro actual
            ],
            'telefono' => 'nullable|string|max:30',
            'password' => ['nullable', 'string', 'confirmed', Password::min(8)], // Contraseña es opcional al editar
        ]);

        // 2. Preparar datos para actualizar (excluir contraseña si está vacía)
        $updateData = [
            'nombre' => $validatedData['nombre'],
            'especialidad' => $validatedData['especialidad'],
            'correo' => $validatedData['correo'],
            'telefono' => $validatedData['telefono'],
        ];

        if (!empty($validatedData['password'])) {
            $updateData['password'] = Hash::make($validatedData['password']);
        }

        // 3. Actualizar el entrenador
        $entrenador->update($updateData);

        // 4. Redirigir con un mensaje de éxito
        return redirect()->route('admin.trainers.index')
            ->with('success', '¡Entrenador actualizado exitosamente!');
    }

    public function destroy(Entrenador $entrenador)
    {
        try {
            $entrenador->delete();
            return redirect()->route('admin.trainers.index')
                ->with('success', '¡Entrenador eliminado exitosamente!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.trainers.index')
                ->with('error', 'No se pudo eliminar el entrenador debido a una restricción de base de datos o porque está asociado a otros registros.');
        } catch (\Exception $e) {
            return redirect()->route('admin.trainers.index')
                ->with('error', 'Ocurrió un error inesperado al intentar eliminar el entrenador.');
        }
    }
}