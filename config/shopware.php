<?php

return [
    "grant_type"     => "client_credentials",
    'hostname'       => env('SHOPWARE_HOSTNAME', ''),
    "client_id"      => env("SHOPWARE_CLIENT_ID", ""),
    "client_secret"  => env("SHOPWARE_CLIENT_SECRET", ""),
    "client-options" => [
        "user-agent" => "flooris/shopware-api",
    ],
];
