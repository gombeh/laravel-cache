<?php


return [
    'default' => env('CUSTOM_CACHE_DRIVER', 'file'),


    'stores' => [
        'database' => [
            'driver' => 'database',
            'table' => 'cache',
        ],

        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
        ],

    ],
];
