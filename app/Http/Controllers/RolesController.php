<?php

namespace App\Http\Controllers;

use App\DataTables\RolesDataTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    /**
     * Display a listing of the FileType.
     *
     * @param RolesDataTable $SolicitudAfiliadosDatatables
     * @return Response
     */
    public function index(RolesDataTable $RolesDataTable)
    {
        // $this->isSuperAdmin();
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

        flash('Rol actualizado correctamente!');

        return redirect()->route('roles');
    }
}
