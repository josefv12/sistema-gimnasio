<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoMembresia;
use Illuminate\Validation\Rule; // Necesario para la regla unique al actualizar

class MembershipTypeController extends Controller
{
    public function index()
    {
        $membershipTypes = TipoMembresia::all();
        return view('admin.membership_types.index', ['membershipTypes' => $membershipTypes]);
    }

    public function create()
    {
        return view('admin.membership_types.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100|unique:Tipo_Membresia,nombre',
            'descripcion' => 'required|string',
            'duracion_dias' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,inactivo',
        ]);

        TipoMembresia::create($validatedData);

        return redirect()->route('admin.membership_types.index')
                         ->with('success', '¡Tipo de membresía creado exitosamente!');
    }

    public function edit(TipoMembresia $tipoMembresia)
    {
        return view('admin.membership_types.edit', ['membershipType' => $tipoMembresia]);
    }

    /**
     * Actualiza un tipo de membresía existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoMembresia  $tipoMembresia // Route Model Binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TipoMembresia $tipoMembresia)
    {
        // 1. Validar los datos del formulario
        // La regla 'unique' para 'nombre' debe ignorar el registro actual
        $validatedData = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('Tipo_Membresia', 'nombre')->ignore($tipoMembresia->id_tipo_membresia, 'id_tipo_membresia')
            ],
            'descripcion' => 'required|string',
            'duracion_dias' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,inactivo',
        ]);

        // 2. Actualizar el tipo de membresía con los datos validados
        $tipoMembresia->update($validatedData);

        // 3. Redirigir con un mensaje de éxito
        return redirect()->route('admin.membership_types.index')
                         ->with('success', '¡Tipo de membresía actualizado exitosamente!');
    }

    /**
     * Elimina un tipo de membresía específico de la base de datos.
     *
     * @param  \App\Models\TipoMembresia  $tipoMembresia // Route Model Binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TipoMembresia $tipoMembresia)
    {
        try {
            // Intentar eliminar el tipo de membresía
            $tipoMembresia->delete();

            return redirect()->route('admin.membership_types.index')
                             ->with('success', '¡Tipo de membresía eliminado exitosamente!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Capturar excepciones de consulta, comúnmente por restricciones de clave foránea
            // El código '23000' es un código de error SQLSTATE genérico para violación de integridad.
            // En MySQL, una violación de FK específica a menudo devuelve el código de error 1451.
            // Puedes ser más específico si conoces el código de error de tu SGBD.
            if ($e->getCode() === '23000' || str_contains($e->getMessage(), 'constraint violation')) {
                return redirect()->route('admin.membership_types.index')
                                 ->with('error', 'No se puede eliminar este tipo de membresía porque está siendo utilizado o tiene datos asociados.');
            }
            // Para otros errores de base de datos
            return redirect()->route('admin.membership_types.index')
                             ->with('error', 'Error al eliminar el tipo de membresía: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Capturar cualquier otra excepción general
            return redirect()->route('admin.membership_types.index')
                             ->with('error', 'Ocurrió un error inesperado al intentar eliminar el tipo de membresía: ' . $e->getMessage());
        }
    }
}