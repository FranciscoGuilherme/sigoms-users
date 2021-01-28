<?php

return [
    'routes' => [
        /*
        |--------------------------------------------------------------------------
        | Serviço de resgate
        |--------------------------------------------------------------------------
        */
        'orders' => [
            'service' => $_ENV['LEGACY_GPI_SERVICE'],
            'resource' => $_ENV['LEGACY_GPI_RESOURCE']
        ]
    ]
];