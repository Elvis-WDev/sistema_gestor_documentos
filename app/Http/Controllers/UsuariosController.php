<?php

namespace App\Http\Controllers;

use App\DataTables\UsuariosDatatables;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\Traits\RegistrarActividad;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use RealRashid\SweetAlert\Facades\Alert;

class UsuariosController extends Controller
{
    use ImageUploadTrait, HasRoles, RegistrarActividad;
    /**
     * Display a listing of the FileType.
     *
     * @param UsuariosDatatables $UsuariosDatatables
     * @return Response
     */
    public function index(UsuariosDatatables $UsuariosDatatables)
    {
        try {
            return $UsuariosDatatables->render('pages.usuarios.index');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al cargar la DataTable de usuarios', ['exception' => $e]);
            Alert::error('Hubo un problema al cargar usuarios. Por favor, inténtalo de nuevo.');
            return redirect()->route('dashboard');
        }
    }

    public function create()
    {
        try {
            return view('pages.usuarios.create');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al cargar la vista de usuarios', ['exception' => $e]);
            Alert::error('Hubo un problema al cargar la página de usuarios. Por favor, inténtalo de nuevo.');
            return redirect()->route('usuarios');
        }
    }

    public function edit(int $id)
    {
        try {

            $Usuario = User::findOrFail($id);

            return view('pages.usuarios.edit', compact('Usuario'));
        } catch (ModelNotFoundException $e) {
            // Manejo de excepción si no se encuentra el modelo
            Log::error('Usuario no encontrado', ['id' => $id, 'exception' => $e]);
            Alert::error('El usuario solicitado no fue encontrado.');
            return redirect()->route('usuarios');
        } catch (Exception $e) {
            // Manejo de otros errores inesperados
            Log::error('Error al obtener usuario', ['id' => $id, 'exception' => $e]);
            Alert::error('Hubo un problema al obtener los datos del usuario.');
            return redirect()->route('usuarios');
        }
    }

    public function updateProfile(Request $request)
    {

        $request->validate([
            'id' => ['required', 'integer', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'Nombres' => ['required', 'string', 'max:255'],
            'Apellidos' => ['required', 'string', 'max:255'],
        ]);

        try {

            $usuario = User::findOrFail($request->id);

            $usuario->Nombres = $request->Nombres;
            $usuario->Apellidos = $request->Apellidos;
            $usuario->email = $request->email;


            if ($request->hasFile('image')) {
                // Eliminar la imagen anterior si existe
                if ($usuario->url_img && Storage::disk('public')->exists($usuario->url_img)) {
                    Storage::disk('public')->delete($usuario->url_img);
                }

                // Actualizar la imagen usando el método updateImage
                $imagePath = $this->updateImage($request, 'image', 'uploads/usuarios', $usuario->url_img);
                $usuario->url_img = $imagePath;
            }

            if ($request->password) {
                $usuario->password = $request->password;
            }

            $usuario->save();

            toast('Perfil actualizado correctamente', 'success');

            return redirect()->route('perfil.update');
        } catch (Exception $e) {
            // Manejo de errores inesperados
            Log::error('Error al actualizar perfil', ['exception' => $e]);
            Alert::error('Hubo un problema al actualizar el perfil.');
            return redirect()->route('perfil.update');
        }
    }

    public function destroy(int $id)
    {
        try {
            $Usuario = User::findOrFail($id);

            if (!empty($Usuario->url_img)) {

                Storage::disk('public')->delete($Usuario->url_img);
            }

            $Usuario->delete();

            $this->Actividad(
                Auth::user()->id,
                "Ha eliminado un usuario",
                ""
            );

            return response()->json(['status' => 'success', 'message' => 'Usuario eliminado correctamente.']);
        } catch (QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Hubo un problema al eliminar el perfil.']);
        }
    }
}
