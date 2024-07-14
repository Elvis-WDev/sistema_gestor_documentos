<?php

namespace App\Http\Controllers;

use App\DataTables\UsuariosDatatables;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\ImageUploadTrait;
use File;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Auth;
use Flasher\Notyf\Prime\NotyfInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class UsuariosController extends Controller
{
    use ImageUploadTrait, HasRoles;
    /**
     * Display a listing of the FileType.
     *
     * @param UsuariosDatatables $UsuariosDatatables
     * @return Response
     */
    public function index(UsuariosDatatables $UsuariosDatatables)
    {
        // $this->isSuperAdmin();
        return $UsuariosDatatables->render('pages.usuarios.index');
    }


    public function create()
    {
        return view('pages.usuarios.create');
    }

    public function edit(int $id)
    {
        $Usuario = User::findOrFail($id);

        return view('pages.usuarios.edit', compact('Usuario'));
    }

    public function updateProfile(Request $request)
    {

        // dd($request);

        $request->validate([
            'id' => ['required', 'integer', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'Nombres' => ['required', 'string', 'max:255'],
            'Apellidos' => ['required', 'string', 'max:255'],
        ]);

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

        flash('Perfil actualizado correctamente.');

        return redirect()->route('perfil.update');
    }

    public function destroy(int $id)
    {
        try {
            $Usuario = User::findOrFail($id);
            $Usuario->delete();

            flash('Usuario eliminado correctamente!');

            return response()->json(['status' => 'success', 'message' => 'Usuario eliminado correctamente.']);
        } catch (QueryException $e) {

            return response()->json(['status' => 'error', 'message' => 'No se puede eliminar el usuario porque tiene relaciones asociadas.']);
        }
    }
}
