<?php
ini_set('display_errors', 0);
return [
    'settings' => [
        'debug' => true,
        'displayErrorDetails' => true,

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        
        ],

        'menu' => require __DIR__ . '/menu.php'
    ],
];
