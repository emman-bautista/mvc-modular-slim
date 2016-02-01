<?php 

define('APP_PATH', __DIR__ . '/../app/');

/** registering modules */
foreach (glob(APP_PATH.'Modules/*') as $module) {
    $className = basename($module);
    $app->getContainer()->logger->info("Registering >> " . $className);
    $moduleName = "App\\Modules\\$className\\Register";

    $templatePath = APP_PATH."Modules/$className/templates";
    $app->getContainer()->view->getEnvironment()->getLoader()->addPath($templatePath);
    $module = new $moduleName;
    $module->initialize($app);
}
