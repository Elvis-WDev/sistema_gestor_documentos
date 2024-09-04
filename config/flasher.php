<?php

declare(strict_types=1);

namespace Flasher\Laravel\Resources;

return [
    'default' => 'flasher',

    // Generar el enlace a los archivos con asset() para producción
    'main_script' => asset('vendor/flasher/flasher.min.js'),

    'styles' => [
        asset('vendor/flasher/flasher.min.css'),
    ],

    'translate' => true,

    'inject_assets' => true,

    'flash_bag' => [
        'success' => ['success'],
        'error' => ['error', 'danger'],
        'warning' => ['warning', 'alarm'],
        'info' => ['info', 'notice', 'alert'],
    ],

    'filter' => [
        'limit' => 5,
    ],

    'plugins' => [
        'notyf' => [
            'scripts' => [
                asset('vendor/flasher/flasher-notyf.min.js'),
            ],
            'styles' => [
                asset('vendor/flasher/flasher-notyf.min.css'),
            ],
            'options' => [
                'dismissible' => true,
            ],
        ],
    ],

];
