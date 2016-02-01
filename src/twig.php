<?php 


// Fetch DI Container
$container = $app->getContainer();

// Register Twig View helper
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../templates/', [
        //'cache' => 'path/to/cache'
    ]);

    // Instantiate and add Slim specific extension
    $view->addExtension(new Slim\Views\TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));

    return $view;
};

//Add Global variables in twig
$twig_environment = $container['view']->getEnvironment();
$twig_environment->addGlobal('menu',  require __DIR__ . '/menu.php');