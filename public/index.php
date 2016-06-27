<?php

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
use App\Core\AppContainer as App;

$app = App::getInstance($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Set up database 
require __DIR__ . '/../src/database.php';

// Set up ACL
require __DIR__ . '/../src/acl.php';

// Register middleware
require __DIR__ . '/../src/twig.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Register Modules
require __DIR__ . '/../src/modules.php';

// Events
require __DIR__ . '/../src/events.php';


// Run app
$app->run();

?>
