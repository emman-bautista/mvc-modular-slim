<?php 
// Fetch DI Container
$container = $app->getContainer();

// Register Twig View helper
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../templates/', [
        //'cache' => 'path/to/cache'
        'debug' => true
    ]);

    // Instantiate and add Slim specific extension
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $c['request']->getUri()));

    $view->addExtension(new Twig_Extension_Debug());

    $view->addExtension(new App\Utilities\TwigExtension($c['flash']));

	$view->getEnvironment()->addGlobal('menu',  require __DIR__ . '/menu.php');
	$view->getEnvironment()->addGlobal('messages',  $c->flash->getMessages());
	$view->getEnvironment()->addGlobal('identity',  $c->get('authenticator')->getIdentity());
    $view->getEnvironment()->addGlobal('base_url', $c->base_url);
    return $view;
};


// flash message
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};
//Add Global variables in twig
//$twig_environment = $container['view']->getEnvironment();

$container['errorHandler'] = function ($c) use($app){
    return function ($request, $response, $exception) use ($c) {
        //var_dump(get_class($exception));
        $status = 403;
        $message = '';
        switch (get_class($exception)) {
            case 'Illuminate\Database\QueryException':
                $status = 500;
                break;
            
            default:

                $status = 403;
                break;
        }
        
        return $c['response']->withStatus($status)
                             ->withHeader('Content-Type', 'text/html')
                             ->write($c->view->fetch('403.phtml', ['e' => $exception, 'status' => $status, 'request_path' => $request->getUri()->getPath()]));
    };
};