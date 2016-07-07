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

// Setup Constants
require __DIR__ . '/../src/constants.php';
// Set up dependencies
require SOURCES_PATH . '/dependencies.php';

// Register middleware
require SOURCES_PATH . '/middleware.php';

// Set up database 
require SOURCES_PATH . '/database.php';

// Set up ACL
require SOURCES_PATH . '/acl.php';

// Register middleware
require SOURCES_PATH . '/twig.php';

// Register routes
require SOURCES_PATH . '/routes.php';

// Register Modules
require SOURCES_PATH . '/modules.php';

// Events
require SOURCES_PATH . '/events.php';
// Run app
$app->run();

?>
