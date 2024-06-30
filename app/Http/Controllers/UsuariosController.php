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

class UsuariosController extends Controller
{
    use ImageUploadTrait;
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

    public function updateProfile(Request $request, FlasherInterface  $flasher, NotyfInterface $notyf)
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
            if (File::exists(public_path($usuario->image))) {
                File::delete(public_path($usuario->image));
            }
            $imagePath = $this->updateImage($request, 'image', 'uploads/usuarios', $usuario->url_img);
            $usuario->url_img = $imagePath;
        }

        if ($request->password) {
            $usuario->password = $request->password;
        }

        $usuario->save();

        flash('Perfil actualizado correctamente.');

        return redirect()->route(config('rol')[Auth::user()->id_rol] . '.perfil.update');
    }
}