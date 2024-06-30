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
use Illuminate\Validation\Rule;

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

        // dd(config('rol'));

        $request->validate([
            'Nombres' => ['required', 'string', 'max:255'],
            'Apellidos' => ['required', 'string', 'max:255'],
            'NombreUsuario' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'id_rol' => ['required', 'integer', 'exists:roles,id_rol'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'Nombres' => $request->Nombres,
            'Apellidos' => $request->Apellidos,
            'NombreUsuario' => $request->NombreUsuario,
            'id_rol' => $request->id_rol,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        flash('Usuario creado correctamente!');

        return redirect()->route('SuperAdmin.usuarios');
    }

    public function update(Request $request): RedirectResponse
    {

        $request->validate([
            'id' => ['required', 'integer', 'max:255'],
            'Nombres' => ['required', 'string', 'max:255'],
            'Apellidos' => ['required', 'string', 'max:255'],
            'NombreUsuario' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($request->id)],
            'id_rol' => ['required', 'integer', 'exists:roles,id_rol'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);


        $usuario = User::findOrFail($request->id);

        $usuario->Nombres = $request->Nombres;
        $usuario->Apellidos = $request->Apellidos;
        $usuario->NombreUsuario = $request->NombreUsuario;
        $usuario->id_rol = $request->id_rol;
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

        flash('Usuario actualizado correctamente!');

        return redirect()->route('SuperAdmin.usuarios');
    }
}
