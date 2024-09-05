<?php

namespace App\Http\Controllers;

use App\DataTables\RolesDataTable;
use App\Traits\RegistrarActividad;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;
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
        try {
            return $RolesDataTable->render('pages.usuarios.roles.index');
        } catch (Exception $e) {
            // Manejar excepciones y registrar el error
            Log::error('Error al cargar el DataTable de cuentas por cobrar', ['exception' => $e]);
            Alert::erorr('Hubo un problema al cargar las cuentas por cobrar. Por favor, inténtalo de nuevo.');
            return redirect()->route('dashboard');
        }
    }

    public function create()
    {
        try {
            $permissions = Permission::all();
            return view('pages.usuarios.roles.create', compact('permissions'));
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al cargar la página de creación de roles', ['exception' => $e]);
            Alert::erorr('Hubo un problema al cargar los permisos para la creación de roles.');
            return redirect()->route('dashboard');
        }
    }

    public function store(Request $request): RedirectResponse
    {

        try {

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

            toast('Rol creado correctamente!', 'success');

            return redirect()->route('roles');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al crear el rol', ['exception' => $e]);
            Alert::erorr('Hubo un problema al crear el rol.');
            return redirect()->route('roles');
        }
    }
    public function edit($id)
    {
        try {
            // Obtener el rol específico
            $role = Role::find($id);

            // Obtener todos los permisos
            $permissions = Permission::all();

            // Obtener los permisos actuales del rol
            $rolePermissions = $role->permissions->pluck('id')->toArray();

            return view('pages.usuarios.roles.edit', compact('role', 'permissions', 'rolePermissions'));
        } catch (ModelNotFoundException $e) {
            // Manejo de error si el rol no se encuentra
            Alert::erorr('El rol solicitado no existe.');
            return redirect()->route('roles');
        } catch (Exception $e) {
            // Manejo de otros errores inesperados
            Log::error('Error al cargar la página de edición del rol', ['exception' => $e]);
            Alert::erorr('Hubo un problema al cargar la página de edición.');
            return redirect()->route('roles');
        }
    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($request->id)],
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        try {
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

            toast('Rol actualizado correctamente!', 'success');

            return redirect()->route('roles');
        } catch (ModelNotFoundException $e) {
            // Manejo de error si el rol no se encuentra
            Alert::erorr('El rol solicitado no existe.');
            return redirect()->route('roles');
        } catch (Exception $e) {
            // Manejo de otros errores inesperados
            Log::error('Error al actualizar el rol', ['exception' => $e]);
            Alert::erorr('Hubo un problema al actualizar el rol.');
            return redirect()->route('roles');
        }
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

            return response()->json(['status' => 'success', 'message' => 'Rol eliminado correctamente.']);
        } catch (QueryException $e) {

            return response()->json(['status' => 'error', 'message' => 'Hubo un problema al eliminar el rol.']);
        }
    }
}
