<?php

return [
    'grant_type' => 'client_credentials',
    'instances'  => [
        'default' => [
            'hostname'            => env('SHOPWARE_HOSTNAME', ''),
            'access_key_id'       => env('SHOPWARE_ACCESS_KEY_ID', ''),
            'secret_access_key'   => env('SHOPWARE_SECRET_ACCESS_KEY', ''),
            'http-header-options' => [
                'User-Agent' => 'flooris/shopware-api-integration',
            ],
        ],
    ],
];
