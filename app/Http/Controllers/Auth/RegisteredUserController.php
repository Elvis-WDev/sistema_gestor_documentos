<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Traits\ImageUploadTrait;
use File;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'Nombres' => ['required', 'string', 'max:255'],
            'Apellidos' => ['required', 'string', 'max:255'],
            'NombreUsuario' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'id_rol' => ['required', 'integer', 'exists:roles,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'Nombres' => $request->Nombres,
            'Apellidos' => $request->Apellidos,
            'NombreUsuario' => $request->NombreUsuario,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Obtener el rol por ID y asignarlo al usuario
        $role = Role::findById($request->id_rol);
        $user->assignRole($role);

        // event(new Registered($user));

        // Auth::login($user);

        flash('Usuario creado correctamente!');

        return redirect()->route('usuarios');
    }

    public function update(Request $request): RedirectResponse
    {

        $request->validate([
            'id' => ['required', 'integer', 'max:255'],
            'Nombres' => ['required', 'string', 'max:255'],
            'Apellidos' => ['required', 'string', 'max:255'],
            'NombreUsuario' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($request->id)],
            'id_rol' => ['required', 'integer', 'exists:roles,id'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);


        $usuario = User::findOrFail($request->id);

        $usuario->Nombres = $request->Nombres;
        $usuario->Apellidos = $request->Apellidos;
        $usuario->NombreUsuario = $request->NombreUsuario;
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

        // Actualizar rol
        $role = Role::findById($request->id_rol);
        $usuario->syncRoles([$role->name]);

        flash('Usuario actualizado correctamente!');

        return redirect()->route('usuarios');
    }
}
