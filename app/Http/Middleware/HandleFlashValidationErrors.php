<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Flasher\Notyf\Prime\NotyfInterface;

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

        if ($response->isRedirect() && $response->getSession()->has('errors')) {
            $errors = $response->getSession()->get('errors');

            foreach ($errors->getBag('default')->messages() as $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $this->notyf->danger($error);
                }
            }

            $response->getSession()->forget('errors');
        }

        return $response;
    }
}
