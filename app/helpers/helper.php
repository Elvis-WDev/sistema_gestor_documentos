<?php

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
