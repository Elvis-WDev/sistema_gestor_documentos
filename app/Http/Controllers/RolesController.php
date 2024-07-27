<?php

namespace App\Http\Controllers;

use App\DataTables\RolesDataTable;
use App\Traits\RegistrarActividad;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    use RegistrarActividad;

    /**
     * Display a listing of the FileType.
     *
     * @param RolesDataTable $RolesDataTable
     * @return Response
     */
    public function index(RolesDataTable $RolesDataTable)
    {
        return $RolesDataTable->render('pages.usuarios.roles.index');
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('pages.usuarios.roles.create', compact('permissions'));
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        // Crear el nuevo rol
        $role = Role::create(['name' => $request->name]);

        // Asignar los permisos seleccionados al rol
        $role->syncPermissions($request->permissions);

        $this->Actividad(
            Auth::user()->id,
            "Ha registrado un nuevo rol",
            $request->name
        );

        flash('Rol creado correctamente!');

        return redirect()->route('roles');
    }
    public function edit($id)
    {
        // Obtener el rol específico
        $role = Role::find($id);

        // Obtener todos los permisos
        $permissions = Permission::all();

        // Obtener los permisos actuales del rol
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        // Pasar las variables a la vista
        return view('pages.usuarios.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($request->id)],
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::findOrFail($request->id);
        $role->name = $request->name;
        $role->save();

        // Sincronizar los permisos del rol
        $role->syncPermissions($request->permissions);

        $this->Actividad(
            Auth::user()->id,
            "Ha editado un rol",
            $request->name
        );

        flash('Rol actualizado correctamente!');

        return redirect()->route('roles');
    }

    public function destroy(int $id)
    {
        try {
            $Rol = Role::findOrFail($id);
            $tempRol = $Rol;
            $Rol->delete();

            $this->Actividad(
                Auth::user()->id,
                "Ha eliminado un rol",
                $tempRol->name
            );

            flash('Rol eliminado correctamente!');

            return response()->json(['status' => 'success', 'message' => 'Rol eliminado correctamente.']);
        } catch (QueryException $e) {

            return response()->json(['status' => 'error', 'message' => 'No se puede eliminar el rol porque tiene relaciones asociadas.']);
        }
    }
}
