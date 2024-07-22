<?php

use Carbon\Carbon;

function setActive(array $route)
{
    if (is_array($route)) {
        foreach ($route as $r) {
            if (request()->routeIs($r) || request()->is($r . '/*')) {
                return 'active';
            }
        }
    }
    return '';
}


function TiempoTranscurrido($fecha)
{
    $fechaActual = Carbon::now();
    $fechaProporcionada = Carbon::parse($fecha);

    $diferencia = $fechaActual->diff($fechaProporcionada);

    if ($diferencia->y > 0) {
        return 'Hace ' . $diferencia->y . ' años';
    } elseif ($diferencia->m > 0) {
        return 'Hace ' . $diferencia->m . ' meses';
    } elseif ($diferencia->d > 0) {
        return 'Hace ' . $diferencia->d . ' días';
    } elseif ($diferencia->h > 0) {
        return 'Hace ' . $diferencia->h . ' horas';
    } elseif ($diferencia->i > 0) {
        return 'Hace ' . $diferencia->i . ' minutos';
    } else {
        return 'Hace unos segundos';
    }
}
