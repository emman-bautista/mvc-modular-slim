<?php 

define('APP_PATH', __DIR__ . '/../app/');

/** registering modules */
foreach (glob(APP_PATH.'Modules/*') as $module) {
    $moduleName = basename($module);

    $app->getContainer()->logger->info("Registering >> " . $moduleName);
    $className = "App\\Modules\\$moduleName\\Register"; 
    $module = new $className;
}
