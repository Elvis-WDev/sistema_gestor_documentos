<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // $request->authenticate();

        // $request->session()->regenerate();

        // return redirect()->intended(route('dashboard', absolute: false));

        $request->authenticate();

        $request->session()->regenerate();

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Redirigir según el id_rol del usuario
        switch ($user->id_rol) {
            case 1:
                return redirect()->route('SuperAdmin.dashboard');
            case 2:
                return redirect()->route('Administrador.dashboard');
            case 3:
                return redirect()->route('Usuario.dashboard');
            default:
                return redirect()->route('home'); // Ruta por defecto
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
