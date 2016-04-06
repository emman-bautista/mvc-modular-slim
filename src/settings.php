<?php
ini_set('display_errors', 1);
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

        'determineRouteBeforeAppMiddleware' => true,
        //acl is used to provide access control/permission on each role
        'acl' => [
            'roles' => [
                'guest',
                ['member', 'guest'],
                'admin'
            ],
            'permissions' => [
                [ 'route' => '/', 'role' => 'guest', 'methods' => ['GET'] ],
                [ 'route' => '/login', 'role' => 'guest', 'methods' => ['GET', 'POST'] ],
                [ 'route' => '/register', 'role' => 'guest', 'methods' => ['GET', 'POST'] ],
                [ 'route' => '/logout', 'role' => 'member', 'methods' => ['GET'] ],
                [ 'route' => '/create_data', 'role' => 'guest', 'methods' => ['GET'] ]
            ]
        ],
        'menu' => require __DIR__ . '/menu.php'
    ],
];
