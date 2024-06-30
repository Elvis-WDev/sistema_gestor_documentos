<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Flasher\Notyf\Prime\NotyfInterface;
use Flasher\Prime\Factory\NotificationFactory;

class HandleFlashValidationErrors
{
    protected $notyf;

    public function __construct(NotyfInterface $notyf)
    {
        $this->notyf = $notyf;
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Verificar si hay errores de validación en la respuesta
        if ($response->isRedirect() && $response->getSession()->has('errors')) {
            $errors = $response->getSession()->get('errors');

            // Mostrar mensajes de error individualmente usando Notyf
            foreach ($errors->getBag('default')->messages() as $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $this->notyf->danger($error);
                }
            }

            // Limpia los errores de la sesión para que no se muestren más de una vez
            $response->getSession()->forget('errors');
        }

        return $response;
    }
}
